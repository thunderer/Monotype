<?php
namespace Thunder\Monotype\Strategy;

use Thunder\Monotype\StrategyInterface;
use Thunder\Monotype\TypeContainer\TypeContainerInterface;

class AtLeastStrategy implements StrategyInterface
    {
    private $threshold;

    public function __construct($threshold)
        {
        if(!is_int($threshold) || intval($threshold) <= 0)
            {
            throw new \InvalidArgumentException('Threshold must be a valid integer!');
            }

        $this->threshold = $threshold;
        }

    public function isValid(TypeContainerInterface $types, $value, array $tests)
        {
        $matches = 0;

        foreach($tests as $alias)
            {
            if(!$types->get($alias))
                {
                $msg = 'Test alias %s does not exist!';
                throw new \RuntimeException(sprintf($msg, $alias));
                }
            if($types->get($alias)->isValid($value))
                {
                $matches++;
                }
            }

        return (bool)($matches >= $this->threshold);
        }
    }
