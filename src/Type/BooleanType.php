<?php
namespace Thunder\Monotype\Type;

use Thunder\Monotype\TestInterface;

/**
 * @author Tomasz Kowalczyk <tomasz@kowalczyk.cc>
 */
final class BooleanType implements TestInterface
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
