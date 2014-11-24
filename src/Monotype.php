<?php
namespace Thunder\Monotype;

/**
 * @author Tomasz Kowalczyk <tomasz@kowalczyk.cc>
 */
final class Monotype
    {
    /** @var StrategyInterface */
    private $strategy;

    /** @var TestInterface[] */
    private $types = array();

    /**
     * @param StrategyInterface $strategy
     * @param TestInterface[] $tests
     */
    public function __construct(StrategyInterface $strategy, array $tests)
        {
        if(empty($tests))
            {
            $msg = 'I am really sorry, but you did not provide any tests...';
            throw new \InvalidArgumentException($msg);
            }

        $this->strategy = $strategy;

        array_map(function(TestInterface $test) {
            $this->addType($test);
            }, $tests);
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

    private function addType(TestInterface $test)
        {
        if(array_key_exists($test->getAlias(), $this->types))
            {
            $msg = 'Duplicate test alias %s!';
            throw new \RuntimeException(sprintf($msg, $test->getAlias()));
            }

        $this->types[$test->getAlias()] = $test;
        }
    }
