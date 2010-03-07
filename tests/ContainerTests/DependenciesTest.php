<?php

class Base_tests_DiTests_ContainerTests_DependenciesTest extends PHPUnit_Framework_TestCase {
	
	/**
	 * @var Base_Di_Container_Dependencies
	 */
	private $dependenciesForTest;
	
	protected function setUp() {
		$this->dependenciesForTest = new Base_Di_Container_Dependencies();
	}

    public function testGetReal() {
        $object = new stdClass();
        $object->name = 'test';
        $this->dependenciesForTest->set('test', $object);

        $getObject = $this->dependenciesForTest->get('test');

        $this->assertEquals(
            'test',
            $getObject->name
        );

    }

    public function testGetNotFoundCreateNewInstance() {
        $getObject = $this->dependenciesForTest->get('Base_tests_DiTests_stubs_Dummy');

        $this->assertEquals(
            'world',
            $getObject->hello()
        );
    }


	
}