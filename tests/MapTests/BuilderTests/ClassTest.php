<?php

require_once 'PHPUnit/Framework.php';

require_once 'Pd/Map/Builder/Class.php';
require_once dirname(__FILE__) . '/../stubs/Dummy.php';


class PdTests_MapTests_BuilderTests_ClassTest extends PHPUnit_Framework_TestCase {

    /**
     * @var Pd_Map_Builder_Class
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

        $items = $this->builder->map()->itemsFor('constructor');

        $this->assertEquals(
                'Banana',
                $items[0]->dependencyName()
        );

    }

    public function testBuildMethodRegular() {

        $this->builder->setup();
        $this->builder->buildMethods();

        $items = $this->builder->map()->itemsFor('method');

        $this->assertEquals(
                'Apple',
                $items[0]->dependencyName()
        );

    }

    public function testBuildProperties() {

        $this->builder->setup();
        $this->builder->buildProperties();

        $items = $this->builder->map()->itemsFor('property');

        $this->assertEquals(
                'Pear',
                $items[0]->dependencyName()
        );

    }

    public function testBuildClassCount() {

        $this->builder->setup();
        $this->builder->buildClass();

        $this->assertEquals(
                5,
                $this->builder->map()->count()
        );

    }


    public function testBuildClassItem2() {

        $this->builder->setup();
        $this->builder->buildClass();

        $items = $this->builder->map()->itemsFor('method');

        $this->assertEquals(
                'PdTests_stubs_Something',
                $items[1]->newClass()
        );

    }

    public function testBuildAll() {

        $this->builder->build();

        $this->assertEquals(
                8,
                $this->builder->map()->count()
        );


    }


    protected function tearDown() {
        unset($this->builder);
    }


}