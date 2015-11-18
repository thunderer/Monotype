<?php
namespace Thunder\Monotype\TypeContainer;

use Thunder\Monotype\TypeInterface;

/**
 * @author Tomasz Kowalczyk <tomasz@kowalczyk.cc>
 */
final class TypeContainer implements TypeContainerInterface
    {
    /** @var TypeInterface[] */
    private $types = array();

    public function add($alias, TypeInterface $test)
        {
        if(array_key_exists($alias, $this->types))
            {
            $msg = 'Duplicate test alias %s!';
            throw new \RuntimeException(sprintf($msg, $alias));
            }

        $this->types[$alias] = $test;

        return $this;
        }

    public function get($alias)
        {
        return $this->has($alias) ? $this->types[$alias] : null;
        }

    private function has($alias)
        {
        return array_key_exists($alias, $this->types);
        }
    }
