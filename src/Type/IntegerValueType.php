<?php
namespace Thunder\Monotype\Type;

use Thunder\Monotype\TypeInterface;

/**
 * @author Tomasz Kowalczyk <tomasz@kowalczyk.cc>
 */
final class IntegerValueType implements TypeInterface
    {
    public function isValid($value)
        {
        $stringValueTest = new StringValueType();

        return $stringValueTest->isValid($value)
            ? ctype_digit((string)$value)
            : false;
        }

    public function getAlias()
        {
        return '@integer';
        }
    }
