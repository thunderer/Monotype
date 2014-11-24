<?php
namespace Thunder\Monotype\Strategy;

use Thunder\Monotype\StrategyInterface;

class AllStrategy implements StrategyInterface
    {
    public function isValid(array $types, $value, array $tests)
        {
        foreach($tests as $alias)
            {
            if(!array_key_exists($alias, $types))
                {
                $msg = 'Test alias %s does not exist!';
                throw new \RuntimeException(sprintf($msg, $alias));
                }
            if(!$types[$alias]->isValid($value))
                {
                return false;
                }
            }

        return true;
        }
    }
