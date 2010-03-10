<?php

require_once 'PHPUnit/Framework.php';
require_once 'Pd/Map/Item.php';

class PdTests_MapTests_ItemTest extends PHPUnit_Framework_TestCase {

    /**
     * @var Pd_Map_Item
     */
    private $item;

    protected function setUp() {
        $this->item = new Pd_Map_Item();
        $this->item->setDependencyName('My Dependency');
        $this->item->setInjectAs('mySomething');
        $this->item->setInjectWith('method');
        $this->item->setForce(true);
    }

    public function testName() {
        $this->assertEquals('My Dependency', $this->item->dependencyName());
    }

    public function testInjectAs() {
        $this->assertEquals('mySomething', $this->item->injectAs());
    }

    public function testInjectWith() {
        $this->assertEquals('method', $this->item->injectWith());
    }

    public function testForce() {
        $this->assertTrue($this->item->force());
    }

    public function tearDown() {
        unset($this->item);
    }

}