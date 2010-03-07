<?php

class Base_tests_DiTests_ContainerTests_ContainerTest extends PHPUnit_Framework_TestCase {

    /**
     * @var Base_Di_Container
     */
    private $container;

    protected function setUp() {
        $this->container = Base_Di_Container::get('testing');
        $this->container->dependencies()->set('someValue', 'yellow');
    }

    public function testSameSingleton() {
        $container = Base_Di_Container::get('testing');
        $this->assertEquals('yellow', $container->dependencies()->get('someValue'));
    }

    public function testNewSingleton() {
        $container = Base_Di_Container::get('newTest');
        $this->assertEquals(
            null,
            $container->dependencies()->get('someValue')
        );
    }


}