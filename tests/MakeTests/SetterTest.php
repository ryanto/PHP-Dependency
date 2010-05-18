<?php

require_once 'PHPUnit/Framework.php';

require_once 'Pd/Container.php';
require_once 'Pd/Map.php';
require_once 'Pd/Map/Item.php';

require_once 'Pd/Make/Setter.php';
require_once dirname(__FILE__) . '/../stubs/Dummy.php';
require_once dirname(__FILE__) . '/../stubs/Something.php';

class PdTests_MakeTests_SetterTest extends PHPUnit_Framework_TestCase {

    /**
     * @var Pd_Make_Setter
     */
    private $injector;

    /**
     * @var PdTests_stubs_Dummy
     */
    private $object;

    private $containerName;

    protected function setUp() {

        $this->containerName = 'PdTests_MakeTests_InjectorTest';
        $this->className = 'PdTests_stubs_Dummy';

        $container = Pd_Container::get($this->containerName);

        $container->dependencies()->set('Force', 'a forced var');
        $container->dependencies()->set('Pear', 'a fruit');
        $container->dependencies()->set('Apple', 'it is red');

        $this->object = new PdTests_stubs_Dummy();

        $this->injector = new Pd_Make_Setter();
        $this->injector->setObject($this->object);
        $this->injector->setContainer($container);

        $this->injector->injectObject();

    }

    public function testInjectMethods() {

        $this->assertEquals(
                'it is red',
                $this->object->apple()
        );


    }

    public function testInjectMethodHasNoMethod() {

        $this->setExpectedException('Exception');
        $e = $this->object->doesNotExist;

    }

    public function testInjectMethodNoMethodButForce() {

        $this->assertEquals(
                'a forced var',
                $this->object->forcedVar()
        );

    }

    public function testInjectProperties() {
        
        $this->assertEquals(
                'a fruit',
                $this->object->pear
        );

    }

    public function testInjectPropertieNoProperty() {

        $this->setExpectedException('Exception');
        $e = $this->object->noSuchProperty;

    }

    public function testInjectPropertyNoPropertyButForce() {

        $this->assertEquals(
                'it is red',
                $this->object->forcedProperty
        );

    }

    public function testInjectedNewInstance() {

        $this->assertEquals(
                'a method from the something class',
                $this->object->force2->aMethod(),
                'new instance method call'
        );

        $this->assertEquals(
                'it is red',
                $this->object->force2->apple(),
                'injected dep into new instance'
        );


    }

    public function testStaticInjector() {

        $this->object = new PdTests_stubs_Dummy();
        Pd_Make_Setter::inject($this->object, $this->containerName);

        $this->assertEquals(
                'a fruit',
                $this->object->pear
        );

    }


    protected function tearDown() {
        unset($this->injector);
        unset($this->object);
        unset($this->containerName);
    }

}