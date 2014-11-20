<?php
namespace Thunder\Monotype;

class MonotypeValue
    {
    private $value;
    private $monotype;

    public function __construct($value)
        {
        $this->value = $value;
        $this->monotype = new Monotype();
        }

    public function isIntegerArray()
        {
        return $this->monotype->isIntegerArray($this->value);
        }

    public function isIntegerLikeArray()
        {
        return $this->monotype->isIntegerLikeArray($this->value);
        }

    public function isFloatArray()
        {
        return $this->monotype->isFloatArray($this->value);
        }

    public function isFloatLikeArray()
        {
        return $this->monotype->isFloatLikeArray($this->value);
        }

    public function isInstanceOfArray($class)
        {
        return $this->isArray() && $this->monotype->isInstanceOfArray($this->value, $class);
        }

    public function isDirectInstanceOfArray($class)
        {
        return $this->isArray() && $this->monotype->isDirectInstanceOfArray($this->value, $class);
        }

    public function isLikeInteger()
        {
        return $this->monotype->isLikeInteger($this->value);
        }

    public function isLikeFloat()
        {
        return $this->monotype->isLikeFloat($this->value);
        }

    public function isLikeString()
        {
        return $this->monotype->isLikeString($this->value);
        }

    public function isTrue()
        {
        return $this->monotype->isTrue($this->value);
        }

    public function isFalse()
        {
        return $this->monotype->isFalse($this->value);
        }

    public function isLikeArray()
        {
        return $this->monotype->isLikeArray($this->value);
        }

    public function isInteger()
        {
        return $this->monotype->isInteger($this->value);
        }

    public function isBoolean()
        {
        return $this->monotype->isBoolean($this->value);
        }

    public function isString()
        {
        return $this->monotype->isString($this->value);
        }

    public function isFloat()
        {
        return $this->monotype->isFloat($this->value);
        }

    public function isInstanceOf($class)
        {
        return $this->monotype->isInstanceOf($this->value, $class);
        }

    public function isDirectInstanceOf($class)
        {
        return $this->monotype->isDirectInstanceOf($this->value, $class);
        }

    public function isCallable()
        {
        return $this->monotype->isCallable($this->value);
        }

    public function isObject()
        {
        return $this->monotype->isObject($this->value);
        }

    public function isScalar()
        {
        return $this->monotype->isScalar($this->value);
        }

    public function isArray()
        {
        return $this->monotype->isArray($this->value);
        }

    public function isNull()
        {
        return $this->monotype->isNull($this->value);
        }
    }
