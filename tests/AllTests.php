<?php

require_once 'PHPUnit/Framework.php';
require_once 'Pd/tests/MapTests/ItemTest.php';

class PdTests_AllTests extends PHPUnit_Framework_TestSuite {

    protected function setUp() {
       

    }

    public static function suite() {

        $suite = new PdTests_AllTests();

        $suite->addTestSuite('PdTests_MapTests_ItemTest');
        

        return $suite;
    }


}
