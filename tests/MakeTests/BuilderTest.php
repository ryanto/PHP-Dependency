<?php

require_once 'PHPUnit/Framework.php';

require_once 'Pd/Container.php';
require_once 'Pd/Map.php';
require_once 'Pd/Map/Item.php';

require_once 'Pd/Make/Builder.php';
require_once dirname(__FILE__) . '/../stubs/Dummy.php';
require_once dirname(__FILE__) . '/../stubs/NonInst.php';

class PdTests_MakeTests_BuilderTest extends PHPUnit_Framework_TestCase {

    /**
     * @var Pd_Make_Builder
     */
    private $builder;

    private $className;

    private $containerName;

    protected function setUp() {

        $this->containerName = 'PdTests_MakeTests_BuilderTest';
        $this->className = 'PdTests_stubs_Dummy';

        $container = Pd_Container::get($this->containerName);

        // the map
        $map = new Pd_Map();

        $item = new Pd_Map_Item();
        $item->setDependencyName('Apple');
        $item->setInjectAs('setApple');
        $item->setInjectWith('method');
        $map->add($item);

        $item = new Pd_Map_Item();
        $item->setDependencyName('Banana');
        $item->setInjectWith('constructor');
        $map->add($item);

        $container->maps()->set($this->className, $map);

        // the dependencies
        $container->dependencies()->set('Apple', 'red');
        $container->dependencies()->set('Banana', 'it was built!');


        // construct it
        $this->builder = new Pd_Make_Builder();
        $this->builder->setContainer($container);
        $this->builder->setClassName($this->className);

    }

    public function testBuilderHasMap() {
        $this->builder->buildObject();
        $object = $this->builder->object();

        $this->assertEquals(
                'it was built!',
                $object->getConstructorArg()
        );
    }

    public function testBuilderDoesNotHaveMap() {
        $this->builder->setClassName('stdClass');
        $this->builder->buildObject();

        $object = $this->builder->object();

        // should this really pass?
        $this->assertEquals(
                new stdClass(),
                $object
        );

    }

    public function testBuildByReadingClassForMap() {
        $containerName = $this->containerName . '_testingReadClass';
        $container = Pd_Container::get($containerName);

        $container->maps()->set($this->className, null);

        $container->dependencies()->set('Apple', 'color:red');
        $container->dependencies()->set('Banana', 'color:yellow');

        $this->builder->setContainer($container);
        $this->builder->buildObject();

        $object = $this->builder->object();

        $this->assertEquals(
                'color:yellow',
                $object->getConstructorArg()
        );

    }

    public function testNonInstantiableClass() {
        $this->builder->setClassName('PdTests_stubs_NonInst');
        $this->builder->buildObject();

        $this->assertNull($this->builder->object());
        
    }

    public function testBuildWithStatic() {

        $object = Pd_Make_Builder::build(
                $this->className,
                $this->containerName
        );

        $this->assertEquals(
                'it was built!',
                $object->getConstructorArg()
        );

    }


    protected function tearDown() {
        unset($this->builder);
        unset($this->className);
        unset($this->containerName);
    }
}