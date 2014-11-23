<?php
namespace Thunder\Monotype\Test;

use Thunder\Monotype\TestInterface;

/**
 * @author Tomasz Kowalczyk <tomasz@kowalczyk.cc>
 */
final class StringValueTest implements TestInterface
    {
    public function isValid($value)
        {
        $objectTest = new ObjectTest();
        $stringTest = new StringTest();

        return $objectTest->isValid($value)
            ? method_exists($value, '__toString')
            : $stringTest->isValid((string)$value);
        }

    public function getAlias()
        {
        return 'string_value';
        }
    }
