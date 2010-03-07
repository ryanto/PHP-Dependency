<?php

class Base_tests_DiTests_MakeTests_BuilderTest extends PHPUnit_Framework_TestCase {
	
	/**
	 * @var Base_Di_Make_Builder
	 */
	private $builder;
	
	private $className;

    private $containerName;

	protected function setUp() {

        $this->containerName = 'Base_tests_DiTests_MakeTests_BuilderTest';
		$this->className = 'Base_tests_DiTests_stubs_Dummy';
		
		$container = Base_Di_Container::get($this->containerName);

		$map = new Base_Di_Map();

        $item = new Base_Di_Map_Item();
        $item->setName('apple');
        $map->add($item);

        $item = new Base_Di_Map_Item();
        $item->setName('constructorArg');
        $item->setType('constructor');
        $map->add($item);

		$container->maps()->set('Base_tests_DiTests_stubs_Dummy', $map);

		$container->dependencies()->set('apple', 'red');
		$container->dependencies()->set('constructorArg', 'it was built!');

		$this->builder = new Base_Di_Make_Builder();
		$this->builder->setContainer($container);
		$this->builder->setClassName('Base_tests_DiTests_stubs_Dummy');
		
	}

    public function testBuildHasMap() {
        $this->builder->buildObject();
        $object = $this->builder->object();

        $this->assertEquals(
            'it was built!',
            $object->getConstructorArg()
        );
    }

    public function testBuildDoesNotHaveMap() {
        $this->builder->setClassName('stdClass');
        $this->builder->buildObject();

        $object = $this->builder->object();

        $this->assertEquals(
            new stdClass(),
            $object
        );

    }
	
	public function testBuildWithStatic() {

        $object = Base_Di_Make_Builder::build(
            $this->className,
            $this->containerName
        );

        $this->assertEquals(
            'it was built!',
            $object->getConstructorArg()
        );

    }
}