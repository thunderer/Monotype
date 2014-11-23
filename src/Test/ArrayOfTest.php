<?php
namespace Thunder\Monotype\Test;

use Thunder\Monotype\TestInterface;

/**
 * @author Tomasz Kowalczyk <tomasz@kowalczyk.cc>
 */
final class ArrayOfTest implements TestInterface
    {
    private $test;
    private $alias;

    public function __construct(TestInterface $test, $alias)
        {
        $this->test = $test;
        $this->alias = $alias;
        }

    public function isValid($value)
        {
        $arrayTest = new ArrayTest();

        return $arrayTest->isValid($value) && array_reduce($value, function($state, $value) {
            return !$state ?: $this->test->isValid($value);
            }, true);
        }

    public function getAlias()
        {
        return $this->alias;
        }
    }
