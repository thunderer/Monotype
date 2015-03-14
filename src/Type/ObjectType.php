<?php
namespace Thunder\Monotype\Type;

use Thunder\Monotype\TypeInterface;

/**
 * @author Tomasz Kowalczyk <tomasz@kowalczyk.cc>
 */
final class ObjectType implements TypeInterface
    {
    public function isValid($value)
        {
        return is_object($value);
        }

    public function getAlias()
        {
        return 'object';
        }
    }
