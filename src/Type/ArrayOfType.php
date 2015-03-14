<?php
namespace Thunder\Monotype\Type;

use Thunder\Monotype\TypeInterface;

/**
 * @author Tomasz Kowalczyk <tomasz@kowalczyk.cc>
 */
final class ArrayOfType implements TypeInterface
    {
    private $test;

    public function __construct(TypeInterface $test)
        {
        $this->test = $test;
        }

    public function isValid($value)
        {
        $arrayTest = new ArrayType();
        $type = $this->test;

        return $arrayTest->isValid($value) && array_reduce($value, function($state, $value) use($type) {
            return !$state ?: $type->isValid($value);
            }, true);
        }

    public function getAlias()
        {
        return $this->test->getAlias().'[]';
        }
    }
