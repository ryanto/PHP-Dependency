<?php

require_once 'Pd/Make/Abstract.php';

/**
 * Injects (read: setter injection) all of the dependencies
 * into the object.
 *
 */

class Pd_Make_Setter extends Pd_Make_Abstract {

    /**
     * Injects all of the properties and methods
     */
    public function injectObject() {

        // load the map
        $this->loadMap();
        $this->_injectMethods();
        $this->_injectProperties();

    }

    private function _injectMethods() {
        /* @var $item Pd_Map_Item */
        
        foreach ($this->_map->itemsFor('method') as $item) {

            // only inject if the class has the method, or the item allows forcing
            $reflector = new ReflectionClass($this->_className);
            if ($reflector->hasMethod($item->injectAs()) || $item->force()) {
                $this->_object->{$item->injectAs()}($this->getDependencyForItem($item));
            }

        }
    }

    private function _injectProperties() {

        /* @var $item Pd_Map_Item */
        foreach ($this->_map->itemsFor('property') as $item) {

            // only inject if the class has the property, or the item allows forcing
            $reflector = new ReflectionClass($this->_className);
            if ($reflector->hasProperty($item->injectAs()) || $item->force()) {
                $this->_object->{$item->injectAs()} = $this->getDependencyForItem($item);
            }

        }
    }
    
    /**
     * Injects everything into the passed object/instance
     *
     * @param mixed $object instance
     * @param string $containerName the container that holds the maps/dependencies
     */
    public static function inject($object, $containerName = 'main') {

        $injector = new self();
        $injector->setObject($object);
        $injector->setContainer(Pd_Container::get($containerName));
        $injector->injectObject();

    }
}
