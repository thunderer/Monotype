<?php
namespace Thunder\Monotype\Test;

use Thunder\Monotype\TestInterface;

/**
 * @author Tomasz Kowalczyk <tomasz@kowalczyk.cc>
 */
final class NullTest implements TestInterface
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
