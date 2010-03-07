<?php

class Base_tests_DiTests_ContainerTests_MapsTest extends PHPUnit_Framework_TestCase {
	
	/**
	 * @var Base_Di_Container_Maps
	 */
	private $maps;
	
	protected function setUp() {
		$this->maps = new Base_Di_Container_Maps();
	}
	
	public function testSetMap() {
        $map = array('a', 'b', 'c');
        $this->maps->set('newMap', $map);

        $getMap = $this->maps->get('newMap');
        $this->assertEquals(
            'b',
            $getMap[1]
        );
	}

    public function testGetNewMapWhenNotFound() {
        $getMap = $this->maps->get('notFound');
        $this->assertEquals(
            0,
            $getMap->count()
        );
    }
	

	
}