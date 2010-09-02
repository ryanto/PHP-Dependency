<?php

require_once 'PHPUnit/Framework.php';

require_once 'Pd/Container/Dependencies.php';

class PdTests_ContainerTests_DependenciesTest extends PHPUnit_Framework_TestCase {

    /**
     * @var Pd_Container_Dependencies
     */
    private $containerDependencies;

    protected function setUp() {
        $this->containerDependencies = new Pd_Container_Dependencies();
    }

    public function testGet() {
        $object = new stdClass();
        $object->name = 'testName';
        $this->containerDependencies->set('test', $object);

        $getObject = $this->containerDependencies->get('test');

        $this->assertEquals(
                'testName',
                $getObject->name
        );

    }

    public function testGetNotFoundNull() {
        $this->assertNull(
                $this->containerDependencies->get('doesntExist')
        );
    }



}