<?php
namespace Thunder\Monotype;

/**
 * @author Tomasz Kowalczyk <tomasz@kowalczyk.cc>
 */
final class Monotype
    {
    private $strategy;
    private $types;

    /**
     * @param StrategyInterface $strategy
     * @param TypeContainerInterface $types
     */
    public function __construct(StrategyInterface $strategy, TypeContainerInterface $types)
        {
        $this->strategy = $strategy;
        $this->types = $types;
        }

    /**
     * Validates given variable against already registered tests referenced by
     * array of their aliases.
     *
     * @param mixed $value
     * @param string[] $tests
     *
     * @return bool
     */
    public function isValid($value, array $tests)
        {
        return $this->strategy->isValid($this->types, $value, $tests);
        }
    }
