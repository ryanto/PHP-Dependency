<?php

require_once 'Pd/Make/Constructor.php';
require_once 'Pd/Make/Setter.php';

class Pd_Make {

    /**
     * Makes an object.  Its the new new.
     *
     *
     * @param string $name the name of the class to create
     * @param string $container the main of the container to use
     * @return object the created class
     */
    public static function name($name, $container = 'main') {

        $object = Pd_Make_Constructor::construct($name, $container);

        Pd_Make_Setter::inject($object, $container);

        return $object;

    }

}

