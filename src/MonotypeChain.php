<?php
namespace Thunder\Monotype;

/**
 * @method MonotypeChain isIntegerArray($array)
 * @method MonotypeChain isIntegerLikeArray($array)
 * @method MonotypeChain isFloatArray($array)
 * @method MonotypeChain isFloatLikeArray($array)
 * @method MonotypeChain isInstanceOfArray($array, $class)
 * @method MonotypeChain isDirectInstanceOfArray($array, $class)
 *
 * @method MonotypeChain isLikeInteger()
 * @method MonotypeChain isLikeFloat()
 * @method MonotypeChain isLikeString()
 * @method MonotypeChain isTrue()
 * @method MonotypeChain isFalse()
 * @method MonotypeChain isLikeArray()
 * @method MonotypeChain isInteger()
 * @method MonotypeChain isBoolean()
 * @method MonotypeChain isString()
 * @method MonotypeChain isFloat()
 * @method MonotypeChain isInstanceOf($class)
 * @method MonotypeChain isDirectInstanceOf($class)
 * @method MonotypeChain isCallable()
 * @method MonotypeChain isObject()
 * @method MonotypeChain isScalar()
 * @method MonotypeChain isArray()
 * @method MonotypeChain isNull()
 */
final class MonotypeChain
    {
    private $checks;
    private $monotype;

    public function __construct()
        {
        $this->monotype = new Monotype();
        }

    public function createBuilder()
        {
        $this->checks = array();

        return $this;
        }

    public function validate($value)
        {
        return array_reduce($this->checks, function($state, $data) use($value) {
            $callable = array($this->monotype, $data['method']);
            $args = array_merge(array($value), $data['args']);

            return $state ? call_user_func_array($callable, $args) : $state;
            }, true);
        }

    public function __call($method, array $args)
        {
        if(!method_exists($this->monotype, $method))
            {
            $msg = 'Method %s does not exist!';
            throw new \BadMethodCallException(sprintf($msg, $method));
            }

        $this->checks[] = array(
            'method' => $method,
            'args' => $args,
            );

        return $this;
        }
    }
