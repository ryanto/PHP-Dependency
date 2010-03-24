<?php

require_once 'PHPUnit/Framework.php';

require_once 'Pd/Map.php';
require_once 'Pd/Map/Item.php';

class PdTests_MapTests_MapTest extends PHPUnit_Framework_TestCase {

    /**
     * @var Pd_Map
     */
    private $map;

    protected function setUp() {
        $this->map = new Pd_Map();

        $item = new Pd_Map_Item();
        $item->setDependencyName('depend');
        $item->setInjectAs('myDepend');
        $item->setInjectWith('setter');

        $this->map->add($item);
    }


    public function testAdd() {
        $item = new Pd_Map_Item();
        $this->map->add($item);

        $this->assertEquals(
                2,
                $this->map->count()
        );
    }

    public function testMapItems() {
        $this->assertEquals(1, count($this->map->items()));
    }

    public function testItemsFor() {
        $item = new Pd_Map_Item();
        $item->setDependencyName('abc');
        $item->setInjectAs('abc');
        $item->setInjectWith('test');

        $this->map->add($item);

        $items = $this->map->itemsFor('test');

        $this->assertEquals(
                $items[0]->dependencyName(),
                'abc'
        );
    }

    public function testCount() {
        $this->assertEquals(
                1,
                $this->map->count()
        );
    }

    public function testHasShouldHave() {
        $this->assertTrue($this->map->has('setter'));
    }

    public function testHasShouldNotHave() {
        $this->assertFalse($this->map->has('testType'));
    }

    protected function tearDown() {
        unset($this->map);
    }

}