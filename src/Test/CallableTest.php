<?php
namespace Thunder\Monotype\Test;

use Thunder\Monotype\TestInterface;

/**
 * @author Tomasz Kowalczyk <tomasz@kowalczyk.cc>
 */
final class CallableTest implements TestInterface
    {
    public function isValid($value)
        {
        return is_callable($value);
        }

    public function getAlias()
        {
        return 'callable';
        }
    }
