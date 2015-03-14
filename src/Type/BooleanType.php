<?php
namespace Thunder\Monotype\Type;

use Thunder\Monotype\TypeInterface;

/**
 * @author Tomasz Kowalczyk <tomasz@kowalczyk.cc>
 */
final class BooleanType implements TypeInterface
    {
    public function isValid($value)
        {
        return is_bool($value);
        }

    public function getAlias()
        {
        return 'boolean';
        }
    }
