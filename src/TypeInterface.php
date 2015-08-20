<?php
namespace Thunder\Monotype;

/**
 * @author Tomasz Kowalczyk <tomasz@kowalczyk.cc>
 */
interface TypeInterface
    {
    /**
     * Tests if given value passes implemented test.
     *
     * @param mixed $value
     *
     * @return bool
     */
    public function isValid($value);
    }
