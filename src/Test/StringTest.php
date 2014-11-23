<?php
namespace Thunder\Monotype\Test;

use Thunder\Monotype\TestInterface;

/**
 * @author Tomasz Kowalczyk <tomasz@kowalczyk.cc>
 */
final class StringTest implements TestInterface
    {
    public function isValid($value)
        {
        return is_string($value);
        }

    public function getAlias()
        {
        return 'string';
        }
    }
