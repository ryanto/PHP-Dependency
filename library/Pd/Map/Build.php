<?php
/**
 * This class will read a class and build a dependency map
 * for it based off the doc blocks.
 *
 * @author ryan
 */
class Pd_Map_Build {

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



    }

    private function _buildMethods() {

        $methods = $this->_reflect->getMethods();

        foreach($methods as $method) {

            if ($this->_checkForCmd($docBlock)) {
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

    private function _checkForCmd($docBlock) {
        return (strpos($docBlock, '@PdInject') !== false);
    }

    /**
     *
     * @PdInject new Class
     * @PdInject DependencyName
     * @PdInject DependencyName with method:setName force
     * @PdInject DependencyName with property:name
     * @PdInject DependencyName with constructor:1
     * 
     *
     */
    private function _parseCmd($cmd) {
        preg_match('/^@PdInject(.*)/i', $cmd, $matches);
        print $matches;

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
