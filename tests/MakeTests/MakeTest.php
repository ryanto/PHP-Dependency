<?php

require_once 'PHPUnit/Framework.php';

require_once 'Pd/Container.php';
require_once 'Pd/Make.php';

require_once dirname(__FILE__) . '/../stubs/Dummy.php';
require_once dirname(__FILE__) . '/../stubs/Something.php';

class PdTests_MakeTests_MakeTest extends PHPUnit_Framework_TestCase {

    private $className;

    private $containerName;

    /**
     * @var PdTests_stubs_Dummy
     */
    private $object;

    protected function setUp() {

        $this->containerName = 'PdTests_MakeTests_MakeTest';
        $this->className = 'PdTests_stubs_Dummy';

        $container = Pd_Container::get($this->containerName);

        $container->dependencies()->set('Force', 'a forced var');
        $container->dependencies()->set('Pear', 'a fruit');
        $container->dependencies()->set('Apple', 'red!!!');

        $this->object = Pd_Make::name($this->className, $this->containerName);

    }

    public function testMake() {
        $this->assertEquals(
                'red!!!',
                $this->object->apple()
        );
    }

    public function test2ndDegreeMake() {
        $this->assertEquals(
                'red!!!',
                $this->object->force2->apple()
        );
    }



    protected function tearDown() {
        unset($this->object);
        unset($this->className);
        unset($this->containerName);
    }

}