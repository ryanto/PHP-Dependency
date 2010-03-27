<?php

require_once 'PHPUnit/Framework.php';

require_once 'Pd/Container/Dependencies.php';

class PdTests_ContainerTests_DependenciesTest extends PHPUnit_Framework_TestCase {

    /**
     * @var Pd_Container_Dependencies
     */
    private $dependencies;

    protected function setUp() {
        $this->dependencies = new Pd_Container_Dependencies();
    }

    public function testGet() {
        $object = new stdClass();
        $object->name = 'testName';
        $this->dependencies->set('test', $object);

        $getObject = $this->dependencies->get('test');

        $this->assertEquals(
                'testName',
                $getObject->name
        );

    }

    public function testGetNotFoundNull() {
        $this->assertNull(
                $this->dependencies->get('doesntExist')
        );
    }



}