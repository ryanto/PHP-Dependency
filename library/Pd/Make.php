<?php
/**
 * Description of Make
 *
 * @author ryan
 */
class Pd_Make {

    public static function name($name, $container = 'main') {

        $object = Pd_Make_Builder::build($name, $container);

        Pd_Make_Injector::inject($object, $container);

        return $object;

    }

}

