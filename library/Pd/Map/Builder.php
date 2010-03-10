<?php
/**
 * This class will read a class and build a dependency map
 * (of items) based off the doc blocks.
 *
 * @author ryan
 */

require_once 'Pd/Map/Item.php';

class Pd_Map_Builder {

    private $_class;
    private $_map;

    /**
     * @var ReflectionClass
     */
    private $_reflect;

    public function setClass($class) {
        $this->_class = $class;
    }

    public function map() {
        return $this->_map;
    }

    public function build() {

        $this->_reflect = new ReflectionClass($this->_class);

        $this->_buildMethods();



    }

    private function _buildMethods() {

        $methods = $this->_reflect->getMethods();

        foreach($methods as $method) {

            if ($this->_checkForCmd($method->getDocComment())) {

                $options = $this->_parseCmd($method->getDocComment());


                if ($method->getName() == '__construct') {
                    $options['injectWith'] = 'constructor';
                } else {
                    $options['injectWith'] = 'method';
                }

                $options['injectAs'] = $method->getName();
            }

        }
    }

    private function _checkForCmd($docBlock = '') {
        return (strpos($docBlock, '@PdInject ') !== false);
    }

    /**
     */
    private function _parseCmd($cmd) {

        
        /*
        if (!$matched) {
            throw new Exception('No commands matched.  Make sure your syntax is correct');
        }
         * 
         */

        var_dump($matches);
        exit;

        $params = explode(" ", $matches[1]);
        var_dump($params);

        // grab dependency name
        if (count($params) < 1) {
            throw new Exception('You must supply a dependency name when using @PdInject');
        }

        // parse out all options

        


        return array();
    }

    
    private function _makeItemFromOptions($options) {
        $item = new Pd_Map_Item();
        $item->setDependencyName($options['dependencyName']);
        $item->setInjectWith($options['injectWith']);
        $item->setInjectAs($options['injectAs']);
        $item->setForce($options['force']);

        return $item;
    }


}
