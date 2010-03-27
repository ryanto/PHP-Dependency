<?php

require_once 'PHPUnit/Framework.php';

require_once 'Pd/Container.php';

class PdTests_ContainerTests_ContainerTest extends PHPUnit_Framework_TestCase {

    protected function setUp() {
        $container = Pd_Container::get('testing');
        $container->dependencies()->set('someValue', 'yellow');
    }

    public function testSameSingleton() {
        $container = Pd_Container::get('testing');
        $this->assertEquals('yellow', $container->dependencies()->get('someValue'));
    }

    public function testNewSingleton() {
        $container = Pd_Container::get('newTest');
        $this->assertEquals(
            null,
            $container->dependencies()->get('someValue')
        );
    }


}