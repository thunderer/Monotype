<?php
namespace Thunder\Monotype;

/**
 * @author Tomasz Kowalczyk <tomasz@kowalczyk.cc>
 */
final class Monotype
    {
    /* --- TYPED ARRAYS ---------------------------------------------------- */

    public function isIntegerArray($array)
        {
        return $this->isArray($array) && array_reduce($array, function($state, $value) {
            return !$state ?: $this->isInteger($value);
            }, true);
        }

    public function isIntegerLikeArray($array)
        {
        return $this->isArray($array) && array_reduce($array, function($state, $value) {
            return !$state ?: $this->isLikeInteger($value);
            }, true);
        }

    public function isFloatArray($array)
        {
        return $this->isArray($array) && array_reduce($array, function($state, $value) {
            return !$state ?: $this->isFloat($value);
            }, true);
        }

    public function isFloatLikeArray($array)
        {
        return $this->isArray($array) && array_reduce($array, function($state, $value) {
            return !$state ?: $this->isLikeFloat($value);
            }, true);
        }

    public function isInstanceOfArray($array, $class)
        {
        return $this->isArray($array) && array_reduce($array, function($state, $value) use($class) {
            return !$state ?: $this->isInstanceOf($value, $class);
            }, true);
        }

    public function isDirectInstanceOfArray($array, $class)
        {
        return $this->isArray($array) && array_reduce($array, function($state, $value) use($class) {
            return !$state ?: $this->isDirectInstanceOf($value, $class);
            }, true);
        }

    /* --- CASTABLE TYPES -------------------------------------------------- */

    public function isLikeInteger($value)
        {
        return ctype_digit((string)$value);
        }

    public function isLikeFloat($value)
        {
        return $this->isFloat($value) || (is_numeric((string)$value) && preg_match('/^[0-9]+\\.[0-9]+$/', (string)$value));
        }

    public function isLikeString($value)
        {
        return $this->isObject($value)
            ? method_exists($value, '__toString')
            : $this->isString((string)$value);
        }

    public function isTrue($value)
        {
        return true === (bool)$value;
        }

    public function isFalse($value)
        {
        return false === (bool)$value;
        }

    public function isLikeArray($value)
        {
        return is_array($value) || ($this->isObject($value) && $value instanceof \ArrayAccess);
        }

    /* --- PRIMITIVE TYPES ------------------------------------------------- */

    public function isInteger($value)
        {
        return is_int($value);
        }

    public function isBoolean($value)
        {
        return is_bool($value);
        }

    public function isString($value)
        {
        return is_string($value);
        }

    public function isFloat($value)
        {
        return is_float($value) || is_double($value);
        }

    public function isInstanceOf($object, $class)
        {
        return $object instanceof $class;
        }

    public function isDirectInstanceOf($object, $class)
        {
        return get_class($object) === $class;
        }

    public function isCallable($value)
        {
        return is_callable($value);
        }

    public function isObject($value)
        {
        return is_object($value);
        }

    public function isScalar($value)
        {
        return is_scalar($value);
        }

    public function isArray($value)
        {
        return is_array($value);
        }

    public function isNull($value)
        {
        return is_null($value);
        }
    }
