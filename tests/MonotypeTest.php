<?php
namespace Thunder\Monotype\Tests;

use Thunder\Monotype\Monotype;
use Thunder\Monotype\MonotypeValue;
use Thunder\Monotype\Tests\Dummy\ArrayAccessClass;
use Thunder\Monotype\Tests\Dummy\SubClass;

/**
 * @author Tomasz Kowalczyk <tomasz@kowalczyk.cc>
 */
final class MonotypeTest extends \PHPUnit_Framework_TestCase
    {
    /**
     * @dataProvider provideTests
     */
    public function testIs($expected, $method, array $data)
        {
        $this->assertEquals($expected, call_user_func_array(array(new Monotype(), $method), $data));
        $this->assertEquals($expected, call_user_func_array(array(new MonotypeValue($data[0]), $method), array_slice($data, 1)));
        }

    public function provideTests()
        {
        $mt = new Monotype();

        return array(
            array(true, 'isInteger', array(0)),
            array(false, 'isInteger', array('0')),

            array(true, 'isLikeInteger', array('0')),
            array(false, 'isLikeInteger', array('x')),

            array(true, 'isIntegerArray', array(array(0))),
            array(false, 'isIntegerArray', array(array('0'))),

            array(true, 'isIntegerLikeArray', array(array('0'))),
            array(false, 'isIntegerLikeArray', array(array('x'))),

            array(true, 'isFloatArray', array(array(0.0))),
            array(false, 'isFloatArray', array(array('0'))),

            array(true, 'isFloatLikeArray', array(array('0.0'))),
            array(false, 'isFloatLikeArray', array(array('0'))),

            array(true, 'isInstanceOf', array(new \stdClass(), 'stdClass')),
            array(true, 'isInstanceOf', array(new SubClass(), 'stdClass')),
            array(false, 'isDirectInstanceOf', array(new SubClass(), 'stdClass')),

            array(true, 'isCallable', array(array($mt, 'isInteger'))),
            array(true, 'isCallable', array('strlen')),
            array(false, 'isCallable', array(array())),
            array(false, 'isCallable', array('invalid')),

            array(true, 'isFloat', array(0.0)),
            array(false, 'isFloat', array('0')),

            array(true, 'isLikeFloat', array(0.0)),
            array(true, 'isLikeFloat', array('0.0')),
            array(false, 'isLikeFloat', array('0')),
            array(false, 'isLikeFloat', array('x')),

            array(true, 'isBoolean', array(false)),
            array(true, 'isBoolean', array(true)),
            array(false, 'isBoolean', array(0)),
            array(false, 'isBoolean', array(1)),

            array(true, 'isString', array('x')),
            array(false, 'isString', array(0)),

            array(true, 'isLikeString', array(0)),
            array(false, 'isLikeString', array(new \stdClass())),

            array(true, 'isTrue', array(true)),
            array(true, 'isFalse', array(false)),

            array(true, 'isScalar', array('')),
            array(false, 'isScalar', array(array())),

            array(true, 'isArray', array(array())),
            array(false, 'isArray', array('x')),

            array(true, 'isLikeArray', array(new ArrayAccessClass())),
            array(false, 'isLikeArray', array(new SubClass())),

            array(true, 'isNull', array(null)),
            array(false, 'isNull', array(true)),

            array(true, 'isObject', array(new \stdClass())),
            array(false, 'isObject', array('x')),

            array(true, 'isInstanceOfArray', array(array(new \stdClass()), 'stdClass')),
            array(true, 'isInstanceOfArray', array(array(new SubClass()), 'stdClass')),
            array(false, 'isInstanceOfArray', array(array(new ArrayAccessClass()), 'stdClass')),
            array(true, 'isDirectInstanceOfArray', array(array(new \stdClass()), 'stdClass')),
            array(false, 'isDirectInstanceOfArray', array(array(new SubClass()), 'stdClass')),
        );
        }
    }
