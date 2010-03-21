<?php

require_once 'PHPUnit/Framework.php';
require_once 'Pd/Map/Builder/Parser.php';

class PdTests_MapTests_BuilderTests_ParserTest extends PHPUnit_Framework_TestCase {

    /**
     * @var Pd_Map_Builder_Parser
     */
    private $parser;

    protected function setUp() {
        $this->parser = new Pd_Map_Builder_Parser();
    }

    public function testMatchValidCommand() {
        $this->parser->setString(
                "@PdInject Apple force:true"
        );

        $this->parser->match();

        $this->assertTrue($this->parser->hasCommand());

    }

    public function testMatchNoValidCommand() {
        $this->parser->setString('Abcbxesdgs!@d');
        $this->parser->match();

        $this->assertFalse($this->parser->hasCommand());
    }

    public function testMatchTwoCommands() {

        $this->parser->setString(
                "/**
                    * @PdInject Apple1
                    * @PdInject Apple2 force:true
                    * @PdInject Apple3
                    */
                ");
        $this->parser->match();
        $this->assertEquals(3, $this->parser->numberOfCommands());

    }

    public function testMatchNoDependencyNameGiven() {
        $this->parser->setString("@PdInject");
        $this->parser->match();

        $this->assertTrue($this->parser->hasCommand());

    }

    public function testNoDependencyOrOptions() {
        $this->parser->setString("* @PdInject");
        $this->parser->match();
        $this->parser->buildOptions();

        $options = $this->parser->getOptions();

        $this->assertNull($options[0]['dependencyName']);

    }

    public function testNewClassOnly() {
        $this->parser->setString("* @PdInject new:stdClass");
        $this->parser->match();
        $this->parser->buildOptions();

        $options = $this->parser->getOptions();

        $this->assertEquals('stdClass', $options[0]['newClass']);

    }

    public function testDependency() {
        $this->parser->setString("* @PdInject Apples");
        $this->parser->match();
        $this->parser->buildOptions();

        $options = $this->parser->getOptions();

        $this->assertEquals('Apples', $options[0]['dependencyName']);

    }

    public function testDependencyWithMethodSetter() {
        $this->parser->setString("* @PdInject Apples method:setApples");
        $this->parser->match();
        $this->parser->buildOptions();

        $options = $this->parser->getOptions();

        $this->assertEquals('Apples', $options[0]['dependencyName'], 'name');
        $this->assertEquals('method', $options[0]['injectWith'], 'with');
        $this->assertEquals('setApples', $options[0]['injectAs'], 'as');

    }

    public function testDependencyWithMultipleOptions() {
        $this->parser->setString("* @PdInject Apples method:setApples force:true");
        $this->parser->match();
        $this->parser->buildOptions();

        $options = $this->parser->getOptions();

        $this->assertEquals('Apples', $options[0]['dependencyName'], 'name');
        $this->assertEquals('method', $options[0]['injectWith'], 'with');
        $this->assertEquals('true', $options[0]['force'], 'force');

    }

    public function testDependencyWithBadOption() {
        $this->setExpectedException('Exception');

        $this->parser->setString("* @PdInject Apples method setApples force:true");
        $this->parser->setInfo('abc');
        $this->parser->match();
        $this->parser->buildOptions();

    }

    public function testMultipleCommands() {
        $this->parser->setString(
                "/**
                    * @PdInject Apple1
                    * @PdInject Apple2 force:true
                    * @PdInject Apple3
                    */
                ");
        $this->parser->match();
        $this->parser->buildOptions();

        $options = $this->parser->getOptions();

        $this->assertEquals('Apple1', $options[0]['dependencyName'], '0');
        $this->assertEquals('true', $options[1]['force'], '1');
        $this->assertEquals('Apple3', $options[2]['dependencyName'], '2');
    }

    protected function tearDown() {
        unset($this->parser);
    }


}