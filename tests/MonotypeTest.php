<?php
namespace Thunder\Monotype\Tests;

use Thunder\Monotype\Monotype;
use Thunder\Monotype\Strategy\AllStrategy;
use Thunder\Monotype\Strategy\AtLeastStrategy;
use Thunder\Monotype\Strategy\SingleStrategy;
use Thunder\Monotype\StrategyInterface;
use Thunder\Monotype\Tests\Dummy\Fixture;
use Thunder\Monotype\Type\AliasType;
use Thunder\Monotype\Type\ArrayOfType;
use Thunder\Monotype\Type\ArrayType;
use Thunder\Monotype\Type\ArrayValueType;
use Thunder\Monotype\Type\BooleanType;
use Thunder\Monotype\Type\BooleanValueType;
use Thunder\Monotype\Type\CallableType;
use Thunder\Monotype\Type\CallbackType;
use Thunder\Monotype\Type\ClassType;
use Thunder\Monotype\Type\ClassValueType;
use Thunder\Monotype\Type\FloatType;
use Thunder\Monotype\Type\FloatValueType;
use Thunder\Monotype\Type\IntegerType;
use Thunder\Monotype\Type\IntegerValueType;
use Thunder\Monotype\Type\InterfaceType;
use Thunder\Monotype\Type\NullType;
use Thunder\Monotype\Type\ObjectType;
use Thunder\Monotype\Type\ScalarType;
use Thunder\Monotype\Type\StringType;
use Thunder\Monotype\Type\StringValueType;
use Thunder\Monotype\Tests\Dummy\ArrayAccessClass;
use Thunder\Monotype\Tests\Dummy\SubClass;
use Thunder\Monotype\TypeContainer;

/**
 * @author Tomasz Kowalczyk <tomasz@kowalczyk.cc>
 */
final class MonotypeTest extends \PHPUnit_Framework_TestCase
    {
    /**
     * @dataProvider provideSingleValues
     */
    public function testSingleValues($expected, $method, $data)
        {
        $types = (new TypeContainer())
            ->add('integer', new IntegerType())
            ->add('@integer', new IntegerValueType())
            ->add('float', new FloatType())
            ->add('@float', new FloatValueType())
            ->add('string', new StringType())
            ->add('@string', new StringValueType())
            ->add('array', new ArrayType())
            ->add('@array', new ArrayValueType())
            ->add('boolean', new BooleanType())
            ->add('@boolean', new BooleanValueType())
            ->add('callable', new CallableType())
            ->add('scalar', new ScalarType())
            ->add('object', new ObjectType())
            ->add('null', new NullType())
            ->add('integer[]', new ArrayOfType(new IntegerType()))
            ->add('@integer[]', new ArrayOfType(new IntegerValueType()))
            ->add('float[]', new ArrayOfType(new FloatType()))
            ->add('@float[]', new ArrayOfType(new FloatValueType()));
        $monotype = new Monotype(new AllStrategy(), $types);

        $this->assertEquals($expected, $monotype->isValid($data, array($method)));
        }

    public function provideSingleValues()
        {
        return array(
            array(true, 'integer', 0),
            array(false, 'integer', '0'),

            array(true, '@integer', '0'),
            array(false, '@integer', 'x'),

            array(true, 'callable', array(new ArrayAccessClass(), 'offsetGet')),
            array(true, 'callable', 'strlen'),
            array(false, 'callable', array()),
            array(false, 'callable', 'invalid'),

            array(true, 'float', 0.0),
            array(false, 'float', '0'),

            array(true, '@float', 0.0),
            array(true, '@float', '0.0'),
            array(false, '@float', '0'),
            array(false, '@float', 'x'),

            array(true, 'boolean', false),
            array(true, 'boolean', true),
            array(false, 'boolean', 0),
            array(false, 'boolean', 1),

            array(true, '@boolean', 0),
            array(true, '@boolean', 1),

            array(true, 'string', 'x'),
            array(false, 'string', 0),

            array(true, '@string', 0),
            array(false, '@string', new \stdClass()),

            array(true, 'scalar', ''),
            array(false, 'scalar', array()),

            array(true, 'null', null),
            array(false, 'null', true),

            array(true, 'object', new \stdClass()),
            array(false, 'object', 'x'),

            array(true, 'array', array()),
            array(false, 'array', 'x'),

            array(true, '@array', new ArrayAccessClass()),
            array(false, '@array', new SubClass()),

            array(true, 'integer[]', array(0)),
            array(false, 'integer[]', array('0')),

            array(true, '@integer[]', array('0')),
            array(false, '@integer[]', array('x')),

            array(true, 'float[]', array(0.0)),
            array(false, 'float[]', array('0')),

            array(true, '@float[]', array('0.0')),
            array(false, '@float[]', array('0')),
            );
        }

    /**
     * @dataProvider provideClassTests
     */
    public function testClasses($expected, $method, $data, $class)
        {
        $types = (new TypeContainer())
            ->add('class', new ClassType($class))
            ->add('@class', new ClassValueType($class))
            ->add('class[]', new ArrayOfType(new ClassType('stdClass')))
            ->add('@class[]', new ArrayOfType(new ClassValueType('stdClass')))
            ->add('interface', new InterfaceType('ArrayAccess'));
        $monotype = new Monotype(new AllStrategy(), $types);

        $this->assertEquals($expected, $monotype->isValid($data, array($method)));
        }

    public function provideClassTests()
        {
        return array(
            array(false, 'class', new SubClass(), 'stdClass'),

            array(true, '@class', new \stdClass(), 'stdClass'),
            array(true, '@class', new SubClass(), 'stdClass'),

            array(true, 'class[]', array(new \stdClass()), 'stdClass'),
            array(false, 'class[]', array(new SubClass()), 'stdClass'),

            array(true, '@class[]', array(new \stdClass()), 'stdClass'),
            array(true, '@class[]', array(new SubClass()), 'stdClass'),
            array(false, '@class[]', array(new ArrayAccessClass()), 'stdClass'),

            array(true, 'interface', new ArrayAccessClass(), 'stdClass'),
            array(false, 'interface', new SubClass(), 'stdClass'),
            );
        }

    public function testMultipleClassesWithSingleMonotypeObject()
        {
        $types = (new TypeContainer())
            ->add('class', new ClassType('Thunder\\Monotype\\Tests\\Dummy\\Fixture'))
            ->add('callback', new CallbackType(function($value) {
                $class = 'Thunder\\Monotype\\Tests\\Dummy\\SubClass';

                return is_object($value) && get_class($value) === $class;
                }))
            ->add('class_array', new ClassType('Thunder\\Monotype\\Tests\\Dummy\\ArrayAccessClass'));
        $mt = new Monotype(new SingleStrategy(), $types);

        $this->assertTrue($mt->isValid(new Fixture('x'), array('class')));
        $this->assertTrue($mt->isValid(new SubClass(), array('callback')));
        $this->assertTrue($mt->isValid(new ArrayAccessClass(), array('class_array')));
        }

    /**
     * @dataProvider provideStrategies
     */
    public function testMonotypeNonExistentTestException(StrategyInterface $strategy)
        {
        $types = (new TypeContainer())
            ->add('integer', new IntegerType());
        $this->setExpectedException('RuntimeException');
        $monotype = new Monotype($strategy, $types);
        $monotype->isValid(12, array('@integer'));
        }

    public function provideStrategies()
        {
        return array(
            array(new AllStrategy()),
            array(new SingleStrategy()),
            array(new AtLeastStrategy(1)),
            );
        }

    public function testMonotypeDuplicateTestAliasException()
        {
        $types = new TypeContainer();
        $types->add('integer', new IntegerType());
        $this->setExpectedException('RuntimeException');
        $types->add('integer', new IntegerType());
        }

    public function testOtherStrategies()
        {
        $types = (new TypeContainer())
            ->add('integer', new IntegerType())
            ->add('string', new StringType());
        $monotypeSingle = new Monotype(new SingleStrategy(), $types);
        $this->assertTrue($monotypeSingle->isValid(12, array('integer', 'string')));
        $this->assertTrue($monotypeSingle->isValid('x', array('integer', 'string')));
        $this->assertFalse($monotypeSingle->isValid(new \stdClass(), array('integer', 'string')));

        $types = (new TypeContainer())
            ->add('integer', new IntegerType())
            ->add('@integer', new IntegerValueType())
            ->add('string', new StringType());
        $monotypeAtLeast = new Monotype(new AtLeastStrategy(2), $types);
        $this->assertFalse($monotypeAtLeast->isValid(12, array('integer', 'string')));
        $this->assertTrue($monotypeAtLeast->isValid('12', array('@integer', 'string')));
        $this->assertFalse($monotypeAtLeast->isValid('x', array('integer', 'string')));
        $this->assertFalse($monotypeAtLeast->isValid(new \stdClass(), array('integer', 'string')));
        }

    public function testAtLeastStrategyInvalidThresholdException()
        {
        $this->setExpectedException('InvalidArgumentException');
        new AtLeastStrategy('x');
        }
    }
