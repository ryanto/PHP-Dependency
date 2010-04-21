<?php

require_once 'Pd/Container/Maps.php';
require_once 'Pd/Container/Dependencies.php';

/**
 * Singleton (eww) that holds dependencies/maps.
 *
 *
 */
class Pd_Container {

    private static $_instance = array();

    /**
     * @var Pd_Container_Maps
     */
    private $_maps;

    /**
     * @var Pd_Container_Dependencies
     */
    private $_dependencies;

    private $_name;


    private function __construct() {

    }
    private function __clone() {

    }

    /**
     * Returns one instance singleton
     *
     * @return Pd_Container
     */
    public static function get($container = 'main') {

        if (!isset(self::$_instance[$container])) {
            self::$_instance[$container] = new self();
            self::$_instance[$container]->setName($container);
            self::$_instance[$container]->setup();
        }
        
        return self::$_instance[$container];

    }

    public function setName($name) {
        $this->_name = $name;
    }

    public function name() {
        return $this->_name;
    }

    /**
     * @return Pd_Container_Maps
     */
    public function maps() {
        return $this->_maps;
    }

    /**
     * @return Pd_Container_Dependencies
     */
    public function dependencies() {
        return $this->_dependencies;
    }

    /**
     * Sets up the container by creating a new map
     * and dependency holder.  This function doesn't really
     * need to ever be called, since the get() function
     * calls it when creating a 'new' container.  
     */
    public function setup() {
        $this->_maps = new Pd_Container_Maps();
        $this->_dependencies = new Pd_Container_Dependencies();
    }


}

