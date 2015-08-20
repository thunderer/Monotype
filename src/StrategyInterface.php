<?php
namespace Thunder\Monotype;

interface StrategyInterface
    {
    /**
     * @param TypeContainerInterface $types
     * @param mixed $value
     * @param string[] $tests
     *
     * @return bool
     */
    public function isValid(TypeContainerInterface $types, $value, array $tests);
    }
