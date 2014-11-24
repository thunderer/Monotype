<?php
namespace Thunder\Monotype\Strategy;

use Thunder\Monotype\StrategyInterface;

class AtLeastStrategy implements StrategyInterface
    {
    private $threshold;

    public function __construct($threshold)
        {
        if(!is_int($threshold))
            {
            throw new \InvalidArgumentException('Threshold must be a valid integer!');
            }

        $this->threshold = $threshold;
        }

    public function isValid(array $types, $value, array $tests)
        {
        $matches = 0;

        foreach($tests as $alias)
            {
            if(!array_key_exists($alias, $types))
                {
                $msg = 'Test alias %s does not exist!';
                throw new \RuntimeException(sprintf($msg, $alias));
                }
            if($types[$alias]->isValid($value))
                {
                $matches++;
                }
            }

        return (bool)($matches >= $this->threshold);
        }
    }
