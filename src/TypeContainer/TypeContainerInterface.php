<?php
namespace Thunder\Monotype\TypeContainer;

use Thunder\Monotype\TypeInterface;

/**
 * @author Tomasz Kowalczyk <tomasz@kowalczyk.cc>
 */
interface TypeContainerInterface
    {
    /**
     * @param $alias
     *
     * @return TypeInterface
     */
    public function get($alias);
    }
