<?php
namespace Thunder\Monotype\Type;

use Thunder\Monotype\TypeInterface;

/**
 * @author Tomasz Kowalczyk <tomasz@kowalczyk.cc>
 */
final class InterfaceType implements TypeInterface
    {
    private $interface;

    public function __construct($interface)
        {
        $this->interface = $interface;
        }

    public function isValid($value)
        {
        $className = is_object($value) ? get_class($value) : $value;

        return in_array($this->interface, class_implements($className, true));
        }

    public function getAlias()
        {
        return 'interface';
        }
    }
