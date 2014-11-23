<?php
namespace Thunder\Monotype\Type;

use Thunder\Monotype\TestInterface;

/**
 * @author Tomasz Kowalczyk <tomasz@kowalczyk.cc>
 */
final class ArrayType implements TestInterface
    {
    public function isValid($value)
        {
        return is_array($value);
        }

    public function getAlias()
        {
        return 'array';
        }
    }
