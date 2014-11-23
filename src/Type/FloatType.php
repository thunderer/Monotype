<?php
namespace Thunder\Monotype\Type;

use Thunder\Monotype\TestInterface;

/**
 * @author Tomasz Kowalczyk <tomasz@kowalczyk.cc>
 */
final class FloatType implements TestInterface
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
