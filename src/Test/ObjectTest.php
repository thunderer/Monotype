<?php
namespace Thunder\Monotype\Test;

use Thunder\Monotype\TestInterface;

/**
 * @author Tomasz Kowalczyk <tomasz@kowalczyk.cc>
 */
final class ObjectTest implements TestInterface
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
