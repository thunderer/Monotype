<?php
namespace Thunder\Monotype\Test;

use Thunder\Monotype\TestInterface;

/**
 * @author Tomasz Kowalczyk <tomasz@kowalczyk.cc>
 */
final class ArrayTest implements TestInterface
    {
    public function isValid($value)
        {
        return is_array($value);
        }

    public function getAlias()
        {
        return 'array';
        }
    }
