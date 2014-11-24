<?php
namespace Thunder\Monotype;

interface StrategyInterface
    {
    /**
     * @param TestInterface[] $types
     * @param mixed $value
     * @param string[] $tests
     *
     * @return bool
     */
    public function isValid(array $types, $value, array $tests);
    }
