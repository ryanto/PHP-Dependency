<?php

require_once 'Pd/Make/Abstract.php';

class Pd_Make_Builder extends Pd_Make_Abstract {

    public function buildObject() {

        $this->findMap();

        if ($this->_map->has('constructor')) {

            $constructWith = array();

            foreach($this->_map->itemsFor('constructor') as $item) {
                $constructWith[$item->injectAs()] = $this->getDependencyForItem($item);
            }

            $reflector = new ReflectionClass($this->_className);
            $this->_object = $reflector->newInstanceArgs($constructWith);

        } else {

            $reflector = new ReflectionClass($this->_className);
            if ($reflector->isInstantiable()) {
                $this->_object = new $this->_className();
            } else {
                $this->_object = null;
            }

        }


    }

    public static function build($className, $containerName = 'main') {

        $builder = new self();
        $builder->setClassName($className);
        $builder->setContainer(Pd_Container::get($containerName));
        $builder->buildObject();
        $object = $builder->object();
        unset($builder);

        return $object;
    }

}


