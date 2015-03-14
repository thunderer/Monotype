<?php
namespace Thunder\Monotype;

/**
 * @author Tomasz Kowalczyk <tomasz@kowalczyk.cc>
 */
final class DecoratorBuilder
    {
    private $beforeMethodCall = array();
    private $afterMethodCall = array();
    private $beforePropertySet = array();
    private $afterPropertySet = array();
    private $beforePropertyGet = array();
    private $afterPropertyGet = array();
    private $methodSignature = array();
    private $monotype = null;

    public function __construct()
        {
        }

    public function getDecorator($object)
        {
        return new Decorator($object,
            $this->beforeMethodCall, $this->afterMethodCall,
            $this->beforePropertySet, $this->afterPropertySet,
            $this->beforePropertyGet, $this->afterPropertyGet,
            $this->methodSignature, $this->monotype ? clone $this->monotype : null);
        }

    public function beforeMethodCall($method, callable $handler)
        {
        return $this->addHandler($this->beforeMethodCall, $method, $handler);
        }

    public function afterMethodCall($method, callable $handler)
        {
        return $this->addHandler($this->afterMethodCall, $method, $handler);
        }

    public function beforePropertySet($property, callable $handler)
        {
        return $this->addHandler($this->beforePropertySet, $property, $handler);
        }

    public function afterPropertySet($property, callable $handler)
        {
        return $this->addHandler($this->afterPropertySet, $property, $handler);
        }

    public function beforePropertyGet($property, callable $handler)
        {
        return $this->addHandler($this->beforePropertyGet, $property, $handler);
        }

    public function afterPropertyGet($property, callable $handler)
        {
        return $this->addHandler($this->afterPropertyGet, $property, $handler);
        }

    public function setMonotype(Monotype $monotype)
        {
        $this->monotype = $monotype;

        return $this;
        }

    public function methodSignature($method, $signature, $return, Monotype $monotype = null, callable $handler = null)
        {
        $this->methodSignature[$method] = array($signature, $return, $monotype, $handler);

        return $this;
        }

    public function markProperty($property, $type, Monotype $monotype = null, callable $handler = null)
        {
        $this->methodSignature('get'.ucfirst($property), 'void', array($type), $monotype, $handler);
        $this->methodSignature('set'.ucfirst($property), array(array($type)), 'void', $monotype, $handler);
        $this->beforePropertySet($property, $handler);
        $this->afterPropertySet($property, $handler);
        $this->beforePropertyGet($property, $handler);
        $this->afterPropertyGet($property, $handler);

        return $this;
        }

    private function addHandler(&$container, $name, callable $handler)
        {
        $container[$name][] = $handler;

        return $this;
        }
    }
