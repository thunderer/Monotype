<?php
namespace Thunder\Monotype\Type;

use Thunder\Monotype\TypeInterface;

/**
 * @author Tomasz Kowalczyk <tomasz@kowalczyk.cc>
 */
final class ArrayValueType implements TypeInterface
    {
    public function isValid($value)
        {
        $objectTest = new ObjectType();

        return is_array($value) || ($objectTest->isValid($value) && $value instanceof \ArrayAccess);
        }

    public function getAlias()
        {
        return '@array';
        }
    }
