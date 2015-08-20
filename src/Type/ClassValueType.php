<?php
namespace Thunder\Monotype\Type;

use Thunder\Monotype\TypeInterface;

/**
 * @author Tomasz Kowalczyk <tomasz@kowalczyk.cc>
 */
final class ClassValueType implements TypeInterface
    {
    private $class;

    public function __construct($class)
        {
        $this->class = $class;
        }

    public function isValid($value)
        {
        return $value instanceof $this->class;
        }
    }
