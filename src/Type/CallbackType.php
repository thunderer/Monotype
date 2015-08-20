<?php
namespace Thunder\Monotype\Type;

use Thunder\Monotype\TypeInterface;

/**
 * @author Tomasz Kowalczyk <tomasz@kowalczyk.cc>
 */
final class CallbackType implements TypeInterface
    {
    private $callback;

    public function __construct(callable $callback)
        {
        $this->callback = $callback;
        }

    public function isValid($value)
        {
        return call_user_func_array($this->callback, array($value));
        }
    }
