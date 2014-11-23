<?php
namespace Thunder\Monotype\Tests;

use Thunder\Monotype\Monotype;
use Thunder\Monotype\Test\ArrayOfTest;
use Thunder\Monotype\Test\ArrayTest;
use Thunder\Monotype\Test\ArrayValueTest;
use Thunder\Monotype\Test\BooleanTest;
use Thunder\Monotype\Test\BooleanValueTest;
use Thunder\Monotype\Test\CallableTest;
use Thunder\Monotype\Test\ClassTest;
use Thunder\Monotype\Test\ClassValueTest;
use Thunder\Monotype\Test\FloatTest;
use Thunder\Monotype\Test\FloatValueTest;
use Thunder\Monotype\Test\IntegerTest;
use Thunder\Monotype\Test\IntegerValueTest;
use Thunder\Monotype\Test\NullTest;
use Thunder\Monotype\Test\ObjectTest;
use Thunder\Monotype\Test\ScalarTest;
use Thunder\Monotype\Test\StringTest;
use Thunder\Monotype\Test\StringValueTest;
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
            new IntegerTest(),
            new IntegerValueTest(),
            new FloatTest(),
            new FloatValueTest(),
            new StringTest(),
            new StringValueTest(),
            new ArrayTest(),
            new ArrayValueTest(),
            new BooleanTest(),
            new BooleanValueTest(),
            new CallableTest(),
            new ScalarTest(),
            new ObjectTest(),
            new NullTest(),
            new ArrayOfTest(new IntegerTest(), 'integer_array'),
            new ArrayOfTest(new IntegerValueTest(), 'integer_value_array'),
            new ArrayOfTest(new FloatTest(), 'float_array'),
            new ArrayOfTest(new FloatValueTest(), 'float_value_array'),
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
            new ClassTest($class),
            new ClassValueTest($class),
            new ArrayOfTest(new ClassTest('stdClass'), 'class_array'),
            new ArrayOfTest(new ClassValueTest('stdClass'), 'class_value_array'),
            ));

        $this->assertEquals($expected, $monotype->isValid($data, array($method)));
        }

    public function provideClassTests()
        {
        return array(
            array(true, 'class_value', new \stdClass(), 'stdClass'),
            array(true, 'class_value', new SubClass(), 'stdClass'),
            array(false, 'class', new SubClass(), 'stdClass'),

            array(true, 'class_value_array', array(new \stdClass()), 'stdClass'),
            array(true, 'class_value_array', array(new SubClass()), 'stdClass'),
            array(false, 'class_value_array', array(new ArrayAccessClass()), 'stdClass'),
            array(true, 'class_array', array(new \stdClass()), 'stdClass'),
            array(false, 'class_array', array(new SubClass()), 'stdClass'),
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
            new IntegerTest(),
            ));
        $monotype->isValid(12, array('integer_value'));
        }

    public function testMonotypeDuplicateTestAliasException()
        {
        $this->setExpectedException('RuntimeException');
        new Monotype(array(
            new IntegerTest(),
            new IntegerTest(),
            ));
        }
    }
