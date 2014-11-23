<?php
namespace Thunder\Monotype\Type;

use Thunder\Monotype\TestInterface;

/**
 * @author Tomasz Kowalczyk <tomasz@kowalczyk.cc>
 */
final class IntegerType implements TestInterface
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
