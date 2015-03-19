<?php
namespace Thunder\Monotype\Type;

use Thunder\Monotype\TypeInterface;

/**
 * @author Tomasz Kowalczyk <tomasz@kowalczyk.cc>
 */
final class AliasType implements TypeInterface
    {
    private $alias;
    private $type;

    public function __construct($alias, TypeInterface $type)
        {
        $this->alias = $alias;
        $this->type = $type;
        }

    public function isValid($value)
        {
        return $this->type->isValid($value);
        }

    public function getAlias()
        {
        return $this->alias;
        }
    }
