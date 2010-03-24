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

        $this->buildMethods();



    }

    /**
     * Pass in a reflection item (class, property, method)
     * and this function will build a parser and return its 
     * results.
     * 
     * @param ReflectionClass $classProperty
     * @return array all options
     */
    private function _optionsFrom($classProperty) {
        $parser = new Pd_Map_Builder_Parser();
        $parser->setString($classProperty->getDocComment());
        $parser->setInfo($classProperty);
        $parser->match();
        $parser->buildOptions();

        return $parser->getOptions();
    }

    public function buildMethods() {

        $methods = $this->_reflect->getMethods();

        foreach($methods as $method) {

            foreach ($this->_optionsFrom($method) as $options) {

                if ($method->getName() == '__construct') {
                    $options['injectWith'] = 'constructor';
                } else {
                    $options['injectWith'] = 'method';
                    $options['injectAs'] = $method->getName();
                }

                $this->_map->add(
                        $this->_makeItemFromOptions($options)
                );

            }

        }
    }

    public function buildProperties() {

        $properties = $this->_reflect->getProperties();

        foreach ($properties as $property) {

            foreach ($this->_optionsFrom($property) as $options) {

                $options['injectWith'] = 'property';
                $options['injectAs'] = $property->getName();

                $this->_map->add(
                        $this->_makeItemFromOptions($options)
                );

            }

        }

    }

    public function buildClass() {

        foreach ($this->_optionsFrom($this->_reflect) as $options) {

            $this->_map->add(
                    $this->_makeItemFromOptions($options)
            );

        }

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
