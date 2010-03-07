<?php

class Base_Di_Make_Builder extends Base_Di_Make_Abstract {

    public function buildObject() {

        $this->_findMap();

        if ($this->_map->has('constructor')) {

            // constructor injection

            $constructWith = array();

            foreach($this->_map->map('constructor') as $item) {
                $constructWith[$item->injectAs()] = $this->_container->dependencies()->get($item->name());
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

        $builder = new Base_Di_Make_Builder();
        $builder->setClassName($className);
        $builder->setContainer(Base_Di_Container::get($containerName));
        $builder->buildObject();
        $object = $builder->object();
        unset($builder);

        return $object;
    }

}


