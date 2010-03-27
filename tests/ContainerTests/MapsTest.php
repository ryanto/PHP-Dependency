<?php

require_once 'PHPUnit/Framework.php';

require_once 'Pd/Container/Maps.php';

class PdTests_ContainerTests_MapsTest extends PHPUnit_Framework_TestCase {

    /**
     * @var Pd_Container_Maps
     */
    private $maps;

    protected function setUp() {
        $this->maps = new Pd_Container_Maps();
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