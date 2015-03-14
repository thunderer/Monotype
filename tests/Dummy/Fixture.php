<?php
namespace Thunder\Monotype\Tests\Dummy;

class Fixture
    {
    public $foo;
    private $var;

    public function __construct($var)
        {
        $this->var = $var;
        }

    public function setFoo($foo)
        {
        $this->foo = $foo;
        }

    public function getFoo()
        {
        return $this->foo;
        }

    public function setVar($var)
        {
        $this->var = $var;
        }

    public function getVar()
        {
        return $this->var;
        }
    }
