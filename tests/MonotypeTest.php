<?php
namespace Thunder\Monotype\Tests;

use Thunder\Monotype\Monotype;
use Thunder\Monotype\Type\ArrayOfType;
use Thunder\Monotype\Type\ArrayType;
use Thunder\Monotype\Type\ArrayValueType;
use Thunder\Monotype\Type\BooleanType;
use Thunder\Monotype\Type\BooleanValueType;
use Thunder\Monotype\Type\CallableType;
use Thunder\Monotype\Type\ClassType;
use Thunder\Monotype\Type\ClassValueType;
use Thunder\Monotype\Type\FloatType;
use Thunder\Monotype\Type\FloatValueType;
use Thunder\Monotype\Type\IntegerType;
use Thunder\Monotype\Type\IntegerValueType;
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
        $monotype = new Monotype(array(
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
            new ArrayOfType(new IntegerType(), 'integer_array'),
            new ArrayOfType(new IntegerValueType(), 'integer_value_array'),
            new ArrayOfType(new FloatType(), 'float_array'),
            new ArrayOfType(new FloatValueType(), 'float_value_array'),
            ));

        $this->assertEquals($expected, $monotype->isValid($data, array($method)));
        }

    public function provideSingleValues()
        {
        return array(
            array(true, 'integer', 0),
            array(false, 'integer', '0'),

            array(true, 'integer_value', '0'),
            array(false, 'integer_value', 'x'),

            array(true, 'callable', array(new ArrayAccessClass(), 'offsetGet')),
            array(true, 'callable', 'strlen'),
            array(false, 'callable', array()),
            array(false, 'callable', 'invalid'),

            array(true, 'float', 0.0),
            array(false, 'float', '0'),

            array(true, 'float_value', 0.0),
            array(true, 'float_value', '0.0'),
            array(false, 'float_value', '0'),
            array(false, 'float_value', 'x'),

            array(true, 'boolean', false),
            array(true, 'boolean', true),
            array(false, 'boolean', 0),
            array(false, 'boolean', 1),

            array(true, 'boolean_value', 0),
            array(true, 'boolean_value', 1),

            array(true, 'string', 'x'),
            array(false, 'string', 0),

            array(true, 'string_value', 0),
            array(false, 'string_value', new \stdClass()),

            array(true, 'scalar', ''),
            array(false, 'scalar', array()),

            array(true, 'null', null),
            array(false, 'null', true),

            array(true, 'object', new \stdClass()),
            array(false, 'object', 'x'),

            array(true, 'array', array()),
            array(false, 'array', 'x'),

            array(true, 'array_value', new ArrayAccessClass()),
            array(false, 'array_value', new SubClass()),

            array(true, 'integer_array', array(0)),
            array(false, 'integer_array', array('0')),

            array(true, 'integer_value_array', array('0')),
            array(false, 'integer_value_array', array('x')),

            array(true, 'float_array', array(0.0)),
            array(false, 'float_array', array('0')),

            array(true, 'float_value_array', array('0.0')),
            array(false, 'float_value_array', array('0')),
            );
        }

    /**
     * @dataProvider provideClassTests
     */
    public function testClasses($expected, $method, $data, $class)
        {
        $monotype = new Monotype(array(
            new ClassType($class),
            new ClassValueType($class),
            new ArrayOfType(new ClassType('stdClass'), 'class_array'),
            new ArrayOfType(new ClassValueType('stdClass'), 'class_value_array'),
            ));

        $this->assertEquals($expected, $monotype->isValid($data, array($method)));
        }

    public function provideClassTests()
        {
        return array(
            array(false, 'class', new SubClass(), 'stdClass'),

            array(true, 'class_value', new \stdClass(), 'stdClass'),
            array(true, 'class_value', new SubClass(), 'stdClass'),

            array(true, 'class_array', array(new \stdClass()), 'stdClass'),
            array(false, 'class_array', array(new SubClass()), 'stdClass'),

            array(true, 'class_value_array', array(new \stdClass()), 'stdClass'),
            array(true, 'class_value_array', array(new SubClass()), 'stdClass'),
            array(false, 'class_value_array', array(new ArrayAccessClass()), 'stdClass'),
            );
        }

    public function testMonotypeNoTestsException()
        {
        $this->setExpectedException('InvalidArgumentException');
        new Monotype(array());
        }

    public function testMonotypeNonExistentTestException()
        {
        $this->setExpectedException('RuntimeException');
        $monotype = new Monotype(array(
            new IntegerType(),
            ));
        $monotype->isValid(12, array('integer_value'));
        }

    public function testMonotypeDuplicateTestAliasException()
        {
        $this->setExpectedException('RuntimeException');
        new Monotype(array(
            new IntegerType(),
            new IntegerType(),
            ));
        }
    }
