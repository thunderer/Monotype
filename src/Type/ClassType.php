<?php
namespace Thunder\Monotype\Type;

use Thunder\Monotype\TypeInterface;

/**
 * @author Tomasz Kowalczyk <tomasz@kowalczyk.cc>
 */
final class ClassType implements TypeInterface
    {
    private $class;

    public function __construct($class)
        {
        $this->class = $class;
        }

    public function isValid($value)
        {
        return get_class($value) === $this->class;
        }

    public function getAlias()
        {
        return 'class';
        }
    }
