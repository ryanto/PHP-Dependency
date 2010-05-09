<?php

require_once 'PHPUnit/Framework.php';

require_once 'Pd/Map/Builder/Array.php';


class PdTests_MapTests_BuilderTests_ArrayTest extends PHPUnit_Framework_TestCase {

    /**
     * @var Pd_Map_Builder_Array
     */
    private $builder;

    protected function setUp() {
        $this->builder = new Pd_Map_Builder_Array();

        $this->builder->add(array(
            'dependencyName' => 'database',
            'injectWith' => 'method',
            'injectAs' => 'setDatabase',
        ));
        $this->builder->add(array(
            'dependencyName' => 'apple',
            'injectWith' => 'constructor',
            'injectAs' => 1
        ));
        $this->builder->add(array(
            'injectWith' => 'property',
            'injectAs' => 'theService',
            'force' => true,
            'newClass' => 'Service_Class',
        ));

        $this->builder->build();

    }

    


    protected function tearDown() {
        unset($this->builder);
    }


}