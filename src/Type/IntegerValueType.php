<?php
namespace Thunder\Monotype\Type;

use Thunder\Monotype\TestInterface;

/**
 * @author Tomasz Kowalczyk <tomasz@kowalczyk.cc>
 */
final class IntegerValueType implements TestInterface
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
        return 'integer_value';
        }
    }
