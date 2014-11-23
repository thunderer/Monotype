<?php
namespace Thunder\Monotype\Type;

use Thunder\Monotype\TestInterface;

/**
 * @author Tomasz Kowalczyk <tomasz@kowalczyk.cc>
 */
final class StringType implements TestInterface
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
