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
        $monotype = new Monotype(new AllStrategy(), array(
            new IntegerType(),
            new IntegerValueType(),
            new FloatType(),
            new FloatValueType(),
            new StringType(),
            new StringValueType(),
            new ArrayType(),
            new ArrayValueType(),
            new BooleanType(),
            new BooleanValueType(),
            new CallableType(),
            new ScalarType(),
            new ObjectType(),
            new NullType(),
            new ArrayOfType(new IntegerType()),
            new ArrayOfType(new IntegerValueType()),
            new ArrayOfType(new FloatType()),
            new ArrayOfType(new FloatValueType()),
            ));

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
        $monotype = new Monotype(new AllStrategy(), array(
            new ClassType($class),
            new ClassValueType($class),
            new ArrayOfType(new ClassType('stdClass')),
            new ArrayOfType(new ClassValueType('stdClass')),
            new InterfaceType('ArrayAccess'),
            ));

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
        $mt = new Monotype(new SingleStrategy(), array(
            new ClassType(Fixture::class),
            new CallbackType(function($value) {
                return is_object($value) && get_class($value) === SubClass::class;
                }),
            new AliasType('class_array', new ClassType(ArrayAccessClass::class)),
            ));

        $this->assertTrue($mt->isValid(new Fixture('x'), array('class')));
        $this->assertTrue($mt->isValid(new SubClass(), array('callback')));
        $this->assertTrue($mt->isValid(new ArrayAccessClass(), array('class_array')));
        }

    public function testMonotypeNoTestsException()
        {
        $this->setExpectedException('InvalidArgumentException');
        new Monotype(new AllStrategy(), array());
        }

    /**
     * @dataProvider provideStrategies
     */
    public function testMonotypeNonExistentTestException(StrategyInterface $strategy)
        {
        $this->setExpectedException('RuntimeException');
        $monotype = new Monotype($strategy, array(
            new IntegerType(),
            ));
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
        $this->setExpectedException('RuntimeException');
        new Monotype(new AllStrategy(), array(
            new IntegerType(),
            new IntegerType(),
            ));
        }

    public function testOtherStrategies()
        {
        $monotypeSingle = new Monotype(new SingleStrategy(), array(
            new IntegerType(),
            new StringType(),
            ));
        $this->assertTrue($monotypeSingle->isValid(12, array('integer', 'string')));
        $this->assertTrue($monotypeSingle->isValid('x', array('integer', 'string')));
        $this->assertFalse($monotypeSingle->isValid(new \stdClass(), array('integer', 'string')));

        $monotypeSingle = new Monotype(new AtLeastStrategy(2), array(
            new IntegerType(),
            new IntegerValueType(),
            new StringType(),
            ));
        $this->assertFalse($monotypeSingle->isValid(12, array('integer', 'string')));
        $this->assertTrue($monotypeSingle->isValid('12', array('@integer', 'string')));
        $this->assertFalse($monotypeSingle->isValid('x', array('integer', 'string')));
        $this->assertFalse($monotypeSingle->isValid(new \stdClass(), array('integer', 'string')));
        }

    public function testAtLeastStrategyInvalidThresholdException()
        {
        $this->setExpectedException('InvalidArgumentException');
        new AtLeastStrategy('x');
        }
    }
