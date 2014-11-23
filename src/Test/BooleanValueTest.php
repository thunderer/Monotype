<?php
namespace Thunder\Monotype\Test;

use Thunder\Monotype\TestInterface;

/**
 * @author Tomasz Kowalczyk <tomasz@kowalczyk.cc>
 */
final class BooleanValueTest implements TestInterface
    {
    public function isValid($value)
        {
        return (bool)$value == true || (bool)$value == false;
        }

    public function getAlias()
        {
        return 'boolean_value';
        }
    }
