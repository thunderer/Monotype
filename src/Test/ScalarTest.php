<?php
namespace Thunder\Monotype\Test;

use Thunder\Monotype\TestInterface;

/**
 * @author Tomasz Kowalczyk <tomasz@kowalczyk.cc>
 */
final class ScalarTest implements TestInterface
    {
    public function isValid($value)
        {
        return is_scalar($value);
        }

    public function getAlias()
        {
        return 'scalar';
        }
    }
