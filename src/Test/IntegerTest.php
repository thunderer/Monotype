<?php
namespace Thunder\Monotype\Test;

use Thunder\Monotype\TestInterface;

/**
 * @author Tomasz Kowalczyk <tomasz@kowalczyk.cc>
 */
final class IntegerTest implements TestInterface
    {
    public function isValid($value)
        {
        return is_int($value);
        }

    public function getAlias()
        {
        return 'integer';
        }
    }
