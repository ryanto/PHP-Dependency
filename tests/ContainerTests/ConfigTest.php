<?php

class Base_tests_DiTests_ContainerTests_ConfigTest extends PHPUnit_Framework_TestCase {

    /**
     * @var Base_Di_Container_Config
     */
    private $config;

    private $configDir;

    protected function setUp() {
        $this->config = new Base_Di_Container_Config();

        // config file #1
        $this->configDir = dirname(__FILE__) . '/../stubs/';
        $this->config->addConfigFile(
            $this->configDir . 'DepConf1.ini'
        );
    }
    

    public function testOneConfigFile() {
        $this->config->setClassName('Base_tests_DiTests_stubs_Dummy');
        $map = $this->config->getMap();

        $setters = $map->map('setter');

        $this->assertEquals(
            'apple',
            $setters[0]->name()
        );
    }

    public function testDefaultOptions() {
        $this->config->setClassName('Base_tests_DiTests_stubs_Dummy');
        $map = $this->config->getMap();

        $setters = $map->map('setter');

        $this->assertEquals(
            'pear',
            $setters[1]->injectAs()
        );
    }

    public function testTwoConfigFiles() {

        $this->config->addConfigFile(
            $this->configDir . 'DepConf2.ini'
        );

        $this->config->setClassName('stdClass');

        $map = $this->config->getMap();

        $setters = $map->map('setter');

        $this->assertEquals(
            'person',
            $setters[0]->name()
        );

    }


}