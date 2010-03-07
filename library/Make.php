<?php
/**
 * Description of Make
 *
 * @author ryan
 */
class Base_Di_Make {

    public static function name($name) {

        $object = Base_Di_Make_Builder::build($name);

        Base_Di_Make_Injector::inject($object);

        return $object;

    }

}

