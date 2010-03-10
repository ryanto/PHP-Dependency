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


}