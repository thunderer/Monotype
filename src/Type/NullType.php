<?php
namespace Thunder\Monotype\Type;

use Thunder\Monotype\TestInterface;

/**
 * @author Tomasz Kowalczyk <tomasz@kowalczyk.cc>
 */
final class NullType implements TestInterface
    {
    public function isValid($value)
        {
        return is_null($value);
        }

    public function getAlias()
        {
        return 'null';
        }
    }
