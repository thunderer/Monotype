<?php
namespace Thunder\Monotype\Tests;

use Thunder\Monotype\DecoratorBuilder;
use Thunder\Monotype\Monotype;
use Thunder\Monotype\Strategy\AllStrategy;
use Thunder\Monotype\Tests\Dummy\Fixture;
use Thunder\Monotype\Type\StringType;

interface EventInterface
    {
    const EVENT_BEFORE_METHOD_CALL = 'monotype.event.before_method_call';
    const EVENT_AFTER_METHOD_CALL = 'monotype.event.after_method_call';
    const EVENT_BEFORE_PROPERTY_SET = 'monotype.event.before_property_set';
    const EVENT_AFTER_PROPERTY_SET = 'monotype.event.after_property_set';
    const EVENT_BEFORE_PROPERTY_GET = 'monotype.event.before_property_get';
    const EVENT_AFTER_PROPERTY_GET = 'monotype.event.after_property_get';
    const EVENT_CHECK_METHOD_SIGNATURE = 'monotype.event.check_method_signature';
    }

class SignatureCheckEvent implements EventInterface
    {
    private $signature;
    private $return;

    public function __construct($signature, $return)
        {
        $this->signature = $signature;
        $this->return = $return;
        }

    public function __invoke($value)
        {
        }
    }

/**
 * @author Tomasz Kowalczyk <tomasz@kowalczyk.cc>
 */
final class DecoratorTest extends \PHPUnit_Framework_TestCase
    {
    public function testNewDecorator()
        {
        $statuses = array();
        $monotype = new Monotype(new AllStrategy(), array(new StringType()));
        $builder = DecoratorBuilder::create($monotype)
            ->addEvent(EventInterface::EVENT_BEFORE_METHOD_CALL, 'setVar', function() use(&$statuses) { $statuses[] = 'BMC'; })
            ->addEvent(EventInterface::EVENT_AFTER_METHOD_CALL, 'getVar', function() use(&$statuses) { $statuses[] = 'AMC'; })
            ->addEvent(EventInterface::EVENT_BEFORE_PROPERTY_SET, 'foo', function() use(&$statuses) { $statuses[] = 'BPS'; })
            ->addEvent(EventInterface::EVENT_AFTER_PROPERTY_SET, 'foo', function() use(&$statuses) { $statuses[] = 'APS'; })
            ->addEvent(EventInterface::EVENT_BEFORE_PROPERTY_GET, 'foo', function() use(&$statuses) { $statuses[] = 'BPG'; })
            ->addEvent(EventInterface::EVENT_AFTER_PROPERTY_GET, 'foo', function() use(&$statuses) { $statuses[] = 'APG'; })
            ->addEvent(EventInterface::EVENT_CHECK_METHOD_SIGNATURE, 'setVar', new SignatureCheckEvent(array(array('string')), 'void'))
            ->addEvent(EventInterface::EVENT_CHECK_METHOD_SIGNATURE, 'getVar', new SignatureCheckEvent('void', array('string')))

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

    public function testDecorator()
        {
        $statuses = array();
        $monotype = new Monotype(new AllStrategy(), array(new StringType()));
        $builder = DecoratorBuilder::create()
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
        $builder = DecoratorBuilder::create()
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
        $obj = DecoratorBuilder::create()
            ->methodSignature('getFoo', 'void', array('string'))
            ->getDecorator(new Fixture('x'));
        $this->setExpectedException('RuntimeException');
        /** @var $obj Fixture */
        $obj->getFoo('x');
        }

    public function testMethodWithSignatureInvalidArgumentsCountException()
        {
        $obj = DecoratorBuilder::create()
            ->methodSignature('setFoo', array('string'), 'void')
            ->getDecorator(new Fixture('x'));
        $this->setExpectedException('RuntimeException');
        /** @var $obj Fixture */
        $obj->setFoo('x', 'y');
        }

    public function testMethodWithSignatureMissingMonotypeException()
        {
        $obj = DecoratorBuilder::create()
            ->methodSignature('setFoo', array('string'), 'void')
            ->getDecorator(new Fixture('x'));
        $this->setExpectedException('RuntimeException');
        /** @var $obj Fixture */
        $obj->setFoo('x');
        }

    public function testMethodWithSignatureArgumentTypeMismatchException()
        {
        $monotype = new Monotype(new AllStrategy(), array(new StringType()));
        $obj = DecoratorBuilder::create()
            ->methodSignature('setFoo', array(array('string')), 'void', $monotype)
            ->getDecorator(new Fixture('x'));
        $this->setExpectedException('RuntimeException');
        /** @var $obj Fixture */
        $obj->setFoo(5);
        }

    public function testMethodWithoutSignatureReturn()
        {
        $obj = DecoratorBuilder::create()
            ->getDecorator(new Fixture('x'));
        /** @var $obj Fixture */
        $obj->getFoo();
        }

    public function testMethodDoesNotExistsException()
        {
        $obj = DecoratorBuilder::create()
            ->getDecorator(new Fixture('x'));
        $this->setExpectedException('RuntimeException');
        $obj->invalidMethod();
        }

    public function testPropertyDoesNotExistsException()
        {
        $obj = DecoratorBuilder::create()
            ->getDecorator(new Fixture('x'));
        $this->setExpectedException('RuntimeException');
        $obj->invalidProperty;
        }
    }
