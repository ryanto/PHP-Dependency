<?php

class Base_tests_DiTests_MakeTests_InjectorTest extends PHPUnit_Framework_TestCase {
	
	/**
	 * @var Base_Di_Injector
	 */
	private $injector;
	
	/**
	 * @var Base_tests_DiTests_stubs_Dummy
	 */
	private $object;

    private $containerName;

	protected function setUp() {

        $this->containerName = 'Base_tests_DiTests_MakeTests_InjectorTest';

		$this->object = new Base_tests_DiTests_stubs_Dummy();
		
		$container = Base_Di_Container::get($this->containerName);

		$map = new Base_Di_Map();

        $item = new Base_Di_Map_Item();
        $item->setName('apple');
        $map->add($item);

        $item = new Base_Di_Map_Item();
        $item->setName('My_Pear');
        $item->setInjectAs('pear');
        $map->add($item);

        $item = new Base_Di_Map_Item();
        $item->setName('doesNotExist');
        $map->add($item);

        $item = new Base_Di_Map_Item();
        $item->setName('forcedVar');
        $item->setForce('true');
        $map->add($item);

		$mapDefault = new Base_Di_Map();

        $item = new Base_Di_Map_Item();
        $item->setName('apple');
        $mapDefault->add($item);

        $item = new Base_Di_Map_Item();
        $item->setName('Some_Framework_Pear');
        $item->setInjectAs('pear');
        $mapDefault->add($item);


		$container->maps()->set('Base_tests_DiTests_stubs_Dummy', $map);
		$container->maps()->set('_default', $mapDefault);

		$container->dependencies()->set('apple', 'red');
		$container->dependencies()->set('My_Pear', 'green');
		$container->dependencies()->set('Some_Framework_Pear', 'yellow');
		$container->dependencies()->set('doesNotExist', 'should not be injected');
        $container->dependencies()->set('forcedVar', 'blue');

		$this->injector = new Base_Di_Make_Injector();
		$this->injector->setContainer($container);
		$this->injector->setObject($this->object);
		
	}
	
	public function testInjectUsingOOWithSetter() {
		$this->injector->injectObject();
		$this->assertEquals('red', $this->object->apple());
	}
	
	public function testInjectAsWithPublicProperty() {
		$this->injector->injectObject();
		$this->assertEquals('green', $this->object->pear);
	}
	
	public function testInjectUsingDefaultMap() {
		$container = Base_Di_Container::get($this->containerName);
		$container->maps()->set('Base_tests_DiTests_stubs_Dummy', new Base_Di_Map());
		
		$this->injector->injectObject();
		
		$this->assertEquals('yellow', $this->object->pear);
		
	}
	
	public function testNoMethodOrPropertyExistsOnObject() {
		$container = Base_Di_Container::get($this->containerName);
		
		$this->injector->injectObject();
		
		$this->assertFalse(property_exists($this->object, 'doesNotExist'));
		
	}

    public function testForceInjection() {
        $this->injector->injectObject();
        $this->assertEquals('blue', $this->object->forcedVar());
    }
	
	public function testInjectStatic() {
		Base_Di_Make_Injector::inject($this->object, $this->containerName);
		$this->assertEquals('red', $this->object->apple());
	}
	
}