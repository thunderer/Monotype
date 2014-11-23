<?php
namespace Thunder\Monotype\Test;

use Thunder\Monotype\TestInterface;

/**
 * @author Tomasz Kowalczyk <tomasz@kowalczyk.cc>
 */
final class ArrayValueTest implements TestInterface
    {
    public function isValid($value)
        {
        $objectTest = new ObjectTest();

        return is_array($value) || ($objectTest->isValid($value) && $value instanceof \ArrayAccess);
        }

    public function getAlias()
        {
        return 'array_value';
        }
    }
