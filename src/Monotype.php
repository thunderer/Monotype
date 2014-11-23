<?php
namespace Thunder\Monotype;

/**
 * @author Tomasz Kowalczyk <tomasz@kowalczyk.cc>
 */
final class Monotype
    {
    /** @var TestInterface[] */
    private $tests = array();

    /**
     * @param TestInterface[] $tests
     */
    public function __construct(array $tests)
        {
        if(empty($tests))
            {
            $msg = 'I am really sorry, but you did not provide any tests...';
            throw new \InvalidArgumentException($msg);
            }

        array_map(function(TestInterface $test) {
            $this->addTest($test);
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
        foreach($tests as $alias)
            {
            if(!$this->getTest($alias)->isValid($value))
                {
                return false;
                }
            }

        return true;
        }

    private function addTest(TestInterface $test)
        {
        if($this->hasTest($test->getAlias()))
            {
            $msg = 'Duplicate test alias %s!';
            throw new \RuntimeException(sprintf($msg, $test->getAlias()));
            }

        $this->tests[$test->getAlias()] = $test;
        }

    private function getTest($alias)
        {
        if(!$this->hasTest($alias))
            {
            $msg = 'Non existent test alias %s!';
            throw new \RuntimeException(sprintf($msg, $alias));
            }

        return $this->tests[$alias];
        }

    private function hasTest($alias)
        {
        return array_key_exists($alias, $this->tests);
        }
    }
