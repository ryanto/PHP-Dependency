<?php

class PdTests_stubs_Dummy {

    protected $_apple = null;
    public $pear;
    private $constructorArg;

    private $forcedVar;

    /**
     * @PdInject Apple1
     */
    public function  __construct($constructorArg = null) {
        $this->constructorArg = $constructorArg;
    }

    /**
     * @PdInject Apple
     */
    public function setApple($apple) {
        $this->_apple = $apple;
    }

    public function apple() {
        return $this->_apple;
    }

    public function getConstructorArg() {
        return $this->constructorArg;
    }

    public function hello() {
        return 'world';
    }

    public function __call($name, $args) {
        $var = substr($name, 3, (strlen($name) - 3));
        $var[0] = strtolower($var[0]);

        $this->{$var} = $args[0];

    }

    public function forcedVar() {
        return $this->forcedVar;
    }
}
