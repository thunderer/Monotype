<?php
namespace Thunder\Monotype\Test;

use Thunder\Monotype\TestInterface;

/**
 * @author Tomasz Kowalczyk <tomasz@kowalczyk.cc>
 */
final class FloatValueTest implements TestInterface
    {
    public function isValid($value)
        {
        $floatTest = new FloatTest();

        return $floatTest->isValid($value) || (is_numeric((string)$value) && preg_match('/^[0-9]+\\.[0-9]+$/', (string)$value));
        }

    public function getAlias()
        {
        return 'float_value';
        }
    }
