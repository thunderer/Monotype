<?php
namespace Thunder\Monotype\Type;

use Thunder\Monotype\TypeInterface;

/**
 * @author Tomasz Kowalczyk <tomasz@kowalczyk.cc>
 */
final class ArrayType implements TypeInterface
    {
    public function isValid($value)
        {
        return is_array($value);
        }
    }
