<?php

/**
 * Injection class.
 *
 * Provides an OO way of injecting, and a public static method.
 *
 */

class Base_Di_Make_Injector extends Base_Di_Make_Abstract {

    public function injectObject() {

        $this->_findMap();

        /* @var $item Base_Di_Map_Item */
        foreach ($this->_map->map('setter') as $item) {

            $dependency = $this->_container->dependencies()->get($item->name());

            if ($item->force()) {

                // force a setter
                $this->_object->{'set' . ucfirst($item->injectAs())}($dependency);

            } else{

                // try to find the best injection
                $reflector = new ReflectionClass($this->_className);

                if ($reflector->hasMethod('set' . ucfirst($item->injectAs()))) {
                    $this->_object->{'set' . ucfirst($item->injectAs())}($dependency);

                } elseif ($reflector->hasProperty($item->injectAs())) {
                    $this->_object->{$item->injectAs()} = $dependency;

                }

            } 
        }

    }

    /**
     * @param object $object instance
     * @param string $containerName the container that holds the maps
     */
    public static function inject($object, $containerName = 'main') {

        $injector = new Base_Di_Make_Injector();
        $injector->setObject($object);
        $injector->setContainer(Base_Di_Container::get($containerName));
        $injector->injectObject();
        unset($injector);

    }
}
