<?php
namespace Thunder\Monotype\Type;

use Thunder\Monotype\TestInterface;

/**
 * @author Tomasz Kowalczyk <tomasz@kowalczyk.cc>
 */
final class ObjectType implements TestInterface
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
