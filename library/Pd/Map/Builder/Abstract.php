<?php

require_once 'Pd/Map.php';
require_once 'Pd/Map/Item.php';

/**
 * Abstract class for building maps
 * 
 *
 * @author ryan
 */
class Pd_Map_Builder_Abstract {

    abstract function _setup();
    abstract function _build();

    /**
     * @var Pd_Map
     */
    protected $_map;

    /**
     * The map
     *
     * @return Pd_Map
     */
    public function map() {
        return $this->_map;
    }

    public function setup() {
        $this->_map = new Pd_Map();
    }

    public function build() {
        $this->setup();
        $this->_build();
    }

    /**
     * Creates a Map Item based off options array
     *
     * @param array $options
     * @return Pd_Map_Item
     */
    protected function _makeItemFromOptions($options) {
        $item = new Pd_Map_Item();
        $item->setDependencyName($options['dependencyName']);
        $item->setInjectWith($options['injectWith']);
        $item->setInjectAs($options['injectAs']);
        $item->setForce($options['force']);
        $item->setNewClass($options['newClass']);

        return $item;
    }

}