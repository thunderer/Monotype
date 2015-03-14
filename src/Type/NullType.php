<?php
namespace Thunder\Monotype\Type;

use Thunder\Monotype\TypeInterface;

/**
 * @author Tomasz Kowalczyk <tomasz@kowalczyk.cc>
 */
final class NullType implements TypeInterface
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
