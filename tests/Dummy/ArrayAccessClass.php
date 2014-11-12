<?php
namespace Thunder\Monotype\Tests\Dummy;

class ArrayAccessClass implements \ArrayAccess
    {
    public function offsetExists($offset) {}
    public function offsetGet($offset) {}
    public function offsetSet($offset, $value) {}
    public function offsetUnset($offset) {}
    }
