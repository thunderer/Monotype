<?php
namespace Thunder\Monotype\Type;

use Thunder\Monotype\TypeInterface;

/**
 * @author Tomasz Kowalczyk <tomasz@kowalczyk.cc>
 */
final class FloatValueType implements TypeInterface
    {
    public function isValid($value)
        {
        $floatTest = new FloatType();

        return $floatTest->isValid($value) || (is_numeric((string)$value) && preg_match('/^[0-9]+\\.[0-9]+$/', (string)$value));
        }

    public function getAlias()
        {
        return '@float';
        }
    }
