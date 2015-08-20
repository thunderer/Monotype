<?php
namespace Thunder\Monotype;

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
