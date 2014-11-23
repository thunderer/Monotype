<?php
namespace Thunder\Monotype\Type;

use Thunder\Monotype\TestInterface;

/**
 * @author Tomasz Kowalczyk <tomasz@kowalczyk.cc>
 */
final class ClassValueType implements TestInterface
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

    public function getAlias()
        {
        return 'class_value';
        }
    }
