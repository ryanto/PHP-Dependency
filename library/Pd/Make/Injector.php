<?php

/**
 * Injection class.
 *
 * Provides an OO way of injecting, and a public static method.
 *
 */

class Pd_Make_Injector extends Pd_Make_Abstract {

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
     * @param object $object instance
     * @param string $containerName the container that holds the maps
     */
    public static function inject($object, $containerName = 'main') {

        $injector = new self();
        $injector->setObject($object);
        $injector->setContainer(Pd_Container::get($containerName));
        $injector->injectObject();

    }
}
