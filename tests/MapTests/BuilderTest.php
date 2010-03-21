<?php

require_once 'PHPUnit/Framework.php';

require_once 'Pd/Map/Builder.php';
require_once dirname(__FILE__) . '/../stubs/Dummy.php';


class PdTests_MapTests_BuilderTest extends PHPUnit_Framework_TestCase {

    /**
     * @var Pd_Map_Builder
     */
    private $builder;

    protected function setUp() {
        $this->builder = new Pd_Map_Builder();
        $this->builder->setClass('PdTests_stubs_Dummy');
    }

    public function testBuildMethods() {
        $this->builder->setup();
        $this->builder->buildMethods();

        $this->assertEquals(
                2,
                $this->builder->map()->count()
        );
    }

    public function testBuildMethodConstructor() {
        $this->builder->setup();
        $this->builder->buildMethods();


    }

    public function testBuildMethodRegular() {

    }

    protected function tearDown() {
        unset($this->builder);
    }


}