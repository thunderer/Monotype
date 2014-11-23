<?php
namespace Thunder\Monotype\Type;

use Thunder\Monotype\TestInterface;

/**
 * @author Tomasz Kowalczyk <tomasz@kowalczyk.cc>
 */
final class CallableType implements TestInterface
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
