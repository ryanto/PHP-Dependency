<?php
/**
 * Description of Abstract
 *
 * @author ryan
 */
abstract class Base_Di_Make_Abstract {

    /**
     * @var Base_Di_Map
     */
    protected $_map;

    /**
     * @var Base_Di_Container
     */
    protected $_container;

    protected $_object;
    protected $_className;

    public function setClassName($className) {
        $this->_className = $className;
    }

    public function setContainer($container) {
        $this->_container = $container;
    }

    public function setObject($object) {
        $this->_object = $object;
        $this->setClassName(get_class($object));
    }

    public function object() {
        return $this->_object;
    }

    protected function _findMap() {

        $this->_map = new Base_Di_Map();

        $checkForMapIn = array(
          'getMapFromContainer',
          'getMapFromConfig',
          'getMapFromDefault',
        );

        $counter = 0;
        while ($counter < count($checkForMapIn) && $this->_map->count() == 0) {
            $this->{$checkForMapIn[$counter]}();
            $counter++;
        }

        $this->_saveMapToContainer();

    }

    public function getMapFromContainer() {
        $this->_map = $this->_container->maps()->get($this->_className);
    }
    
    public function getMapFromConfig() {
        $config = $this->_container->config();
        $config->setClassName($this->_className);
        $this->_map = $config->getMap();
    }
    
    public function getMapFromDefault() {
        $default = $this->_container->maps()->get('_default');

        if ($default->count() == 0) {
            $config = $this->_container->config();
            $config->setClassName('_default');
            $default = $config->getMap();
        }

        $this->_map = $default;
    }


    private function _saveMapToContainer() {
        $this->_container->maps()->set($this->_className, $this->_map);
    }



}

