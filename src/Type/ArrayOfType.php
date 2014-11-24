<?php
namespace Thunder\Monotype\Type;

use Thunder\Monotype\TestInterface;

/**
 * @author Tomasz Kowalczyk <tomasz@kowalczyk.cc>
 */
final class ArrayOfType implements TestInterface
    {
    private $test;

    public function __construct(TestInterface $test)
        {
        $this->test = $test;
        }

    public function isValid($value)
        {
        $arrayTest = new ArrayType();

        return $arrayTest->isValid($value) && array_reduce($value, function($state, $value) {
            return !$state ?: $this->test->isValid($value);
            }, true);
        }

    public function getAlias()
        {
        return $this->test->getAlias().'[]';
        }
    }
