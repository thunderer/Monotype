<?php
namespace Thunder\Monotype\Type;

use Thunder\Monotype\TestInterface;

/**
 * @author Tomasz Kowalczyk <tomasz@kowalczyk.cc>
 */
final class ScalarType implements TestInterface
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
