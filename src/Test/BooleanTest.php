<?php
namespace Thunder\Monotype\Test;

use Thunder\Monotype\TestInterface;

/**
 * @author Tomasz Kowalczyk <tomasz@kowalczyk.cc>
 */
final class BooleanTest implements TestInterface
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
