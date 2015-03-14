<?php
namespace Thunder\Monotype\Tests;

use Thunder\Monotype\DecoratorBuilder;
use Thunder\Monotype\Monotype;
use Thunder\Monotype\Strategy\AllStrategy;
use Thunder\Monotype\Tests\Dummy\Fixture;
use Thunder\Monotype\Type\StringType;

/**
 * @author Tomasz Kowalczyk <tomasz@kowalczyk.cc>
 */
final class DecoratorTest extends \PHPUnit_Framework_TestCase
    {
    public function testDecorator()
        {
        $statuses = array();
        $monotype = new Monotype(new AllStrategy(), array(new StringType()));
        $builder = (new DecoratorBuilder())
            ->beforeMethodCall('setVar', function() use(&$statuses) { $statuses[] = 'BMC'; })
            ->afterMethodCall('getVar', function() use(&$statuses) { $statuses[] = 'AMC'; })
            ->beforePropertySet('foo', function() use(&$statuses) { $statuses[] = 'BPS'; })
            ->afterPropertySet('foo', function() use(&$statuses) { $statuses[] = 'APS'; })
            ->beforePropertyGet('foo', function() use(&$statuses) { $statuses[] = 'BPG'; })
            ->afterPropertyGet('foo', function() use(&$statuses) { $statuses[] = 'APG'; })
            ->setMonotype($monotype)
            ->methodSignature('setVar', array(array('string')), 'void', null, function() use(&$statuses) { $statuses[] = 'MS0'; })
            ->methodSignature('getVar', 'void', array('string'), null, function() use(&$statuses) { $statuses[] = 'MS1'; });

        /** @var $obj Fixture */
        $obj = $builder->getDecorator(new Fixture('x'));
        $obj->setVar('y');
        $obj->getVar();
        $obj->foo = 'bar';
        $obj->foo;

        $this->assertContains('BMC', $statuses);
        $this->assertContains('AMC', $statuses);
        $this->assertContains('BPS', $statuses);
        $this->assertContains('APS', $statuses);
        $this->assertContains('BPG', $statuses);
        $this->assertContains('APG', $statuses);
        $this->assertContains('MS0', $statuses);
        $this->assertContains('MS1', $statuses);
        }

    public function testDecoratorPropertyMark()
        {
        $statuses = 0;
        $monotype = new Monotype(new AllStrategy(), array(new StringType()));
        $callback = function() use(&$statuses) { $statuses++; };
        $builder = (new DecoratorBuilder())
            ->markProperty('foo', 'string', $monotype,  $callback);

        /** @var $obj Fixture */
        $obj = $builder->getDecorator(new Fixture('x'));
        $obj->setFoo('y');
        $obj->getFoo();
        $obj->foo = 'bar';
        $obj->foo;

        $this->assertSame(6, $statuses);
        }

    public function testMethodWithVoidSignatureHasArgumentsException()
        {
        $obj = (new DecoratorBuilder())
            ->methodSignature('getFoo', 'void', array('string'))
            ->getDecorator(new Fixture('x'));
        $this->setExpectedException('RuntimeException');
        /** @var $obj Fixture */
        $obj->getFoo('x');
        }

    public function testMethodWithSignatureInvalidArgumentsCountException()
        {
        $obj = (new DecoratorBuilder())
            ->methodSignature('setFoo', array('string'), 'void')
            ->getDecorator(new Fixture('x'));
        $this->setExpectedException('RuntimeException');
        /** @var $obj Fixture */
        $obj->setFoo('x', 'y');
        }

    public function testMethodWithSignatureMissingMonotypeException()
        {
        $obj = (new DecoratorBuilder())
            ->methodSignature('setFoo', array('string'), 'void')
            ->getDecorator(new Fixture('x'));
        $this->setExpectedException('RuntimeException');
        /** @var $obj Fixture */
        $obj->setFoo('x');
        }

    public function testMethodWithSignatureArgumentTypeMismatchException()
        {
        $monotype = new Monotype(new AllStrategy(), array(new StringType()));
        $obj = (new DecoratorBuilder())
            ->methodSignature('setFoo', array(array('string')), 'void', $monotype)
            ->getDecorator(new Fixture('x'));
        $this->setExpectedException('RuntimeException');
        /** @var $obj Fixture */
        $obj->setFoo(5);
        }

    public function testMethodWithoutSignatureReturn()
        {
        $obj = (new DecoratorBuilder())
            ->getDecorator(new Fixture('x'));
        /** @var $obj Fixture */
        $obj->getFoo();
        }

    public function testMethodDoesNotExistsException()
        {
        $obj = (new DecoratorBuilder())
            ->getDecorator(new Fixture('x'));
        $this->setExpectedException('RuntimeException');
        $obj->invalidMethod();
        }

    public function testPropertyDoesNotExistsException()
        {
        $obj = (new DecoratorBuilder())
            ->getDecorator(new Fixture('x'));
        $this->setExpectedException('RuntimeException');
        $obj->invalidProperty;
        }
    }
