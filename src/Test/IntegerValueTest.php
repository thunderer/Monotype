<?php
namespace Thunder\Monotype\Test;

use Thunder\Monotype\TestInterface;

/**
 * @author Tomasz Kowalczyk <tomasz@kowalczyk.cc>
 */
final class IntegerValueTest implements TestInterface
    {
    public function isValid($value)
        {
        $stringValueTest = new StringValueTest();

        return $stringValueTest->isValid($value)
            ? ctype_digit((string)$value)
            : false;
        }

    public function getAlias()
        {
        return 'integer_value';
        }
    }
