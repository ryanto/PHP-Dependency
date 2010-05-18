<?php

require_once 'Pd/Make/Constructor.php';
require_once 'Pd/Make/Setter.php';

class Pd_Make {

    public static function name($name, $container = 'main') {

        $object = Pd_Make_Constructor::construct($name, $container);

        Pd_Make_Setter::inject($object, $container);

        return $object;

    }

}

