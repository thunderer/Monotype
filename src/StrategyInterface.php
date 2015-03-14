<?php
namespace Thunder\Monotype;

interface StrategyInterface
    {
    /**
     * @param TypeInterface[] $types
     * @param mixed $value
     * @param string[] $tests
     *
     * @return bool
     */
    public function isValid(array $types, $value, array $tests);
    }
