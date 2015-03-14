<?php
namespace Thunder\Monotype;

/**
 * @author Tomasz Kowalczyk <tomasz@kowalczyk.cc>
 */
final class Monotype
    {
    /** @var StrategyInterface */
    private $strategy;

    /** @var TypeInterface[] */
    private $types = array();

    /**
     * @param StrategyInterface $strategy
     * @param TypeInterface[] $types
     */
    public function __construct(StrategyInterface $strategy, array $types)
        {
        if(empty($types))
            {
            $msg = 'I am really sorry, but you did not provide any tests...';
            throw new \InvalidArgumentException($msg);
            }

        $this->strategy = $strategy;

        foreach($types as $test)
            {
            $this->addType($test);
            }
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

    private function addType(TypeInterface $test)
        {
        if(array_key_exists($test->getAlias(), $this->types))
            {
            $msg = 'Duplicate test alias %s!';
            throw new \RuntimeException(sprintf($msg, $test->getAlias()));
            }

        $this->types[$test->getAlias()] = $test;
        }
    }
