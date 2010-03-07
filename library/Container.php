<?php

class Base_Di_Container {

    private static $_instance = array();

    /**
     * @var Base_Di_Container_Maps
     */
    private $_maps;

    /**
     * @var Base_Di_Container_Dependencies
     */
    private $_dependencies;


    private function __construct() {

    }
    private function __clone() {

    }

    /**
     * Returns one instance singleton
     *
     * @return Base_Di_Container
     */
    public static function get($container = 'main') {

        if (!isset(self::$_instance[$container])) {
            self::$_instance[$container] = new self();
            self::$_instance[$container]->setup();
        }
        return self::$_instance[$container];

    }

    /**
     * @return Base_Di_Container_Maps
     */
    public function maps() {
        return $this->_maps;
    }

    /**
     * @return Base_Di_Container_Dependencies
     */
    public function dependencies() {
        return $this->_dependencies;
    }

    public function setup() {
        $this->_maps = new Base_Di_Container_Maps();
        $this->_dependencies = new Base_Di_Container_Dependencies();
    }


}

