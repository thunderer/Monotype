<?php
namespace Thunder\Monotype;

/**
 * @author Tomasz Kowalczyk <tomasz@kowalczyk.cc>
 */
interface TestInterface
    {
    /**
     * Tests if given value passes implemented test.
     *
     * @param mixed $value
     *
     * @return bool
     */
    public function isValid($value);

    /**
     * Returns alias of current test to be used in other places.
     *
     * @return string
     */
    public function getAlias();
    }
