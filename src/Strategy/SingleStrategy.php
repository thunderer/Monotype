<?php
namespace Thunder\Monotype\Strategy;

use Thunder\Monotype\StrategyInterface;
use Thunder\Monotype\TypeContainerInterface;

class SingleStrategy implements StrategyInterface
    {
    public function isValid(TypeContainerInterface $types, $value, array $tests)
        {
        foreach($tests as $alias)
            {
            if(!$types->get($alias))
                {
                $msg = 'Test alias %s does not exist!';
                throw new \RuntimeException(sprintf($msg, $alias));
                }
            if($types->get($alias)->isValid($value))
                {
                return true;
                }
            }

        return false;
        }
    }
