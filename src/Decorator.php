<?php
namespace Thunder\Monotype;

/**
 * @author Tomasz Kowalczyk <tomasz@kowalczyk.cc>
 */
final class Decorator
    {
    private $object;
    private $beforeMethodCall = array();
    private $afterMethodCall = array();
    private $beforePropertySet = array();
    private $afterPropertySet = array();
    private $beforePropertyGet = array();
    private $afterPropertyGet = array();
    private $methodSignatures = array();
    private $monotype;

    public function __construct($object,
                                array $beforeMethodCall, array $afterMethodCall,
                                array $beforePropertySet, array $afterPropertySet,
                                array $beforePropertyGet, array $afterPropertyGet,
                                array $methodSignatures, Monotype $monotype = null)
        {
        $this->object = $object;
        $this->beforeMethodCall = $beforeMethodCall;
        $this->afterMethodCall = $afterMethodCall;
        $this->beforePropertySet = $beforePropertySet;
        $this->afterPropertySet = $afterPropertySet;
        $this->beforePropertyGet = $beforePropertyGet;
        $this->afterPropertyGet = $afterPropertyGet;
        $this->methodSignatures = $methodSignatures;
        $this->monotype = $monotype;
        }

    public function __call($method, array $args)
        {
        $this->guardMethod($method);
        $this->guardSignature($method, $args);
        $this->callBeforeHandlers($this->beforeMethodCall, $method, array($this->object, $method, $args));
        $return = call_user_func_array(array($this->object, $method), $args);
        $return = $this->callAfterHandlers($this->afterMethodCall, $method, array($this->object, $method, $args, $return), $return);

        return $return;
        }

    public function __set($property, $value)
        {
        $this->guardProperty($property);
        $this->callBeforeHandlers($this->beforePropertySet, $property, array($this->object, $property, $value));
        $this->object->{$property} = $value;
        $return = $this->callAfterHandlers($this->afterPropertySet, $property, array($this->object, $property, $value), $value);

        return $return;
        }

    public function __get($property)
        {
        $this->guardProperty($property);
        $this->callBeforeHandlers($this->beforePropertyGet, $property, array($this->object, $property));
        $return = $this->object->{$property};
        $return = $this->callAfterHandlers($this->afterPropertyGet, $property, array($this->object, $property, $return), $return);

        return $return;
        }

    private function guardSignature($method, array $args)
        {
        if(!array_key_exists($method, $this->methodSignatures))
            {
            return;
            }
        $signature = $this->methodSignatures[$method][0];
        $callback = $this->methodSignatures[$method][3];
        if('void' === $signature)
            {
            if(!empty($args))
                {
                $msg = 'Failed to verify method %s::%s() signature: expected no parameters, got %s!';
                throw new \RuntimeException(sprintf($msg, get_class($this->object), $method, count($args)));
                }
            !is_callable($callback) ?: $callback($this->object, $method, $args, $signature);
            return;
            }
        if(count($args) !== count($signature))
            {
            $msg = 'Failed to verify method %s::%s() signature: parameter count mismatch, expected %s, got %s!';
            throw new \RuntimeException(sprintf($msg, get_class($this->object), $method, count($signature), count($args)));
            }
        if($this->monotype === null && $this->methodSignatures[$method][2] === null)
            {
            $msg = 'Failed to verify method %s::%s() signature: Monotype instance was not configured!';
            throw new \RuntimeException(sprintf($msg, get_class($this->object), $method));
            }
        /** @var $monotype Monotype */
        $monotype = $this->methodSignatures[$method][2] ?: $this->monotype;
        $count = count($signature);
        for($i = 0; $i < $count; $i++)
            {
            if(!$monotype->isValid($args[$i], $signature[$i]))
                {
                $msg = 'Failed to verify method %s::%s() signature: parameter %s type is invalid, expected %s, got %s!';
                throw new \RuntimeException(sprintf($msg, get_class($this->object), $method, $i, json_encode($signature[$i]), gettype($args[$i])));
                }
            }
        !is_callable($callback) ?: $callback($this->object, $method, $args, $signature);
        }

    private function callBeforeHandlers(array $handlers, $name, array $args)
        {
        if(array_key_exists($name, $handlers) && !empty($handlers[$name]))
            {
            foreach($handlers[$name] as $handler)
                {
                call_user_func_array($handler, $args);
                }
            }
        }

    private function callAfterHandlers(array $handlers, $name, array $args, $return)
        {
        if(array_key_exists($name, $handlers) && !empty($handlers[$name]))
            {
            foreach($handlers[$name] as $handler)
                {
                $return = call_user_func_array($handler, $args);
                }
            }

        return $return;
        }

    private function guardMethod($method)
        {
        if(!method_exists($this->object, $method))
            {
            $msg = 'Method %s::%s() does not exist!';
            throw new \RuntimeException(sprintf($msg, get_class($this->object), $method));
            }
        }

    private function guardProperty($property)
        {
        if(!property_exists($this->object, $property))
            {
            $msg = 'Property %s::%s does not exist!';
            throw new \RuntimeException(sprintf($msg, get_class($this->object), $property));
            }
        }
    }
