<?php

/**
 * @PdInject Force method:setForce force:true
 * @PdInject new:PdTests_stubs_Force method:setForce2 force:true
 *
 */
class PdTests_stubs_Dummy {

    protected $_apple = null;

    /**
     * @PdInject Pear
     */
    public $pear;
    
    private $constructorArg;

    private $forcedVar;

    /**
     * @PdInject Banana
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
