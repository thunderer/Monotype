<?php
namespace Thunder\Monotype\Type;

use Thunder\Monotype\TypeInterface;

/**
 * @author Tomasz Kowalczyk <tomasz@kowalczyk.cc>
 */
final class BooleanValueType implements TypeInterface
    {
    public function isValid($value)
        {
        return (bool)$value === true || (bool)$value === false;
        }

    public function getAlias()
        {
        return '@boolean';
        }
    }
