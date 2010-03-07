<?php

require_once 'PHPUnit/Framework.php';

class Base_tests_DiTests_MapTests_MapTest extends PHPUnit_Framework_TestCase {

	/**
	 * @var Base_Di_Map
	 */
	private $map;

	protected function setUp() {
		$this->map = new Base_Di_Map();

        $item = new Base_Di_Map_Item();
        $item->setName('depend');
        $item->setInjectAs('myDepend');
        $item->setType('setter');

        $this->map->add($item);
	}

    public function testCount() {
        $this->assertEquals(
            1,
            $this->map->count()
        );
    }

    public function testAdd() {
        $item = new Base_Di_Map_Item();
        $this->map->add($item);

        $this->assertEquals(
            2,
            $this->map->count()
        );
    }

    public function testMap() {
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

    public function testHasShouldHave() {
        $this->assertTrue($this->map->has('setter'));
    }

    public function testHasShouldNotHave() {
        $this->assertFalse($this->map->has('testType'));
    }


}