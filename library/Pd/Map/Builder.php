<?php
/**
 * This class will read a class and build a dependency map
 * (of items) based off the doc blocks.
 *
 * @author ryan
 */

require_once 'Pd/Map.php';
require_once 'Pd/Map/Item.php';
require_once 'Pd/Map/Builder/Parser.php';

class Pd_Map_Builder {

    private $_class;

    /**
     * @var Pd_Map
     */
    private $_map;

    /**
     * @var ReflectionClass
     */
    private $_reflect;

    public function setClass($class) {
        $this->_class = $class;
    }

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
        $this->_reflect = new ReflectionClass($this->_class);
    }


    public function build() {

        $this->setup();

        $this->_buildMethods();



    }

    public function buildMethods() {

        $methods = $this->_reflect->getMethods();

        foreach($methods as $method) {

            $parser = new Pd_Map_Builder_Parser();
            $parser->setString($method->getDocComment());
            $parser->setInfo($method);
            $parser->match();
            $parser->buildOptions();

            $allOptions = $parser->getOptions();

            foreach ($allOptions as $options) {

                $this->_map->add(
                        $this->_itemFromMethod($options, $method)
                );
                
            }

        }
    }

    /**
     * Returns an item (tail call to makeItemFromOptions) based
     * off a combination of the passed options and method
     *
     *
     * @param array $options
     * @param ReflectionMethod $method
     * @return Pd_Map_Item
     */
    private function _itemFromMethod($options, $method) {

        if ($method->getName() == '__construct') {
            $options['injectWith'] = 'constructor';
        } else {
            $options['injectWith'] = 'method';
            $options['injectAs'] = $method->getName();
        }

        return $this->_makeItemFromOptions($options);

    }


    /**
     * Creates a Map Item based off options array
     *
     * @param array $options
     * @return Pd_Map_Item
     */
    private function _makeItemFromOptions($options) {
        $item = new Pd_Map_Item();
        $item->setDependencyName($options['dependencyName']);
        $item->setInjectWith($options['injectWith']);
        $item->setInjectAs($options['injectAs']);
        $item->setForce($options['force']);
        $item->setNewClass($options['newClass']);

        return $item;
    }


}
