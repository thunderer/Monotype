<?php
namespace Thunder\Monotype\Type;

use Thunder\Monotype\TypeInterface;

/**
 * @author Tomasz Kowalczyk <tomasz@kowalczyk.cc>
 */
final class StringValueType implements TypeInterface
    {
    public function isValid($value)
        {
        $objectTest = new ObjectType();
        $stringTest = new StringType();

        return $objectTest->isValid($value)
            ? method_exists($value, '__toString')
            : $stringTest->isValid((string)$value);
        }

    public function getAlias()
        {
        return '@string';
        }
    }
