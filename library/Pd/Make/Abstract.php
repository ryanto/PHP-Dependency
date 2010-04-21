<?php

require_once 'Pd/Container.php';
require_once 'Pd/Make.php';
require_once 'Pd/Map/Builder.php';

abstract class Pd_Make_Abstract {

    /**
     * @var Pd_Map
     */
    protected $_map;

    /**
     * @var Pd_Container
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

    /**
     * @return Pd_Map
     */
    private function _getMapFromContainer() {
        $this->_map = $this->_container->maps()->get($this->_className);
    }

    private function _saveMapToContainer() {
        $this->_container->maps()->set($this->_className, $this->_map);
    }

    protected function loadMap() {

        $this->_getMapFromContainer();

        if ($this->_map->count() == 0) {
            $this->_buildMap();
            $this->_saveMapToContainer();
        }

    }

    private function _buildMap() {

        $builder = new Pd_Map_Builder();
        $builder->setClass($this->_className);
        $builder->setup();
        $builder->build();

        $this->_map = $builder->map();

    }

    /**
     * Finds the dependency, new class or pulls from container, based
     * on item.
     *
     * @param Pd_Map_Item $item
     * @return mixed dependency
     */
    protected function getDependencyForItem($item) {

        if ($item->newClass()) {
            $dependency = Pd_Make::name(
                    $item->newClass(),
                    $this->_container->name()
            );
        } else {
            $dependency = $this->_container->dependencies()->get($item->dependencyName());
        }

        return $dependency;
    }




}

