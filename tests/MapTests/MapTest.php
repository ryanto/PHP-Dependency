<?php

require_once 'PHPUnit/Framework.php';

require_once 'Pd/Map/Map.php';

class PdTests_MapTests_MapTest extends PHPUnit_Framework_TestCase {

    /**
     * @var Pd_Map
     */
    private $map;

    protected function setUp() {
        $this->map = new Pd_Map();

        $item = new Pd_Map_Item();
        $item->setName('depend');
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

    public function testMapNoInjectWithParam() {
        $this->assertEquals(1, count($this->map->map()));
    }

    public function testMapWithParam() {
        $item = new Base_Di_Map_Item();
        $item->setName('abc');
        $item->setType('testType');

        $this->map->add($item);

        $testTypes = $this->map->map('testType');

        $this->assertEquals(
                $testTypes[0]->name(),
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


}