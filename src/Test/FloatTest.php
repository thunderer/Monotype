<?php
namespace Thunder\Monotype\Test;

use Thunder\Monotype\TestInterface;

/**
 * @author Tomasz Kowalczyk <tomasz@kowalczyk.cc>
 */
final class FloatTest implements TestInterface
    {
    public function isValid($value)
        {
        return is_float($value) || is_double($value);
        }

    public function getAlias()
        {
        return 'float';
        }
    }
