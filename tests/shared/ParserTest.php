<?php

use PHPUnit\Framework\TestCase;
use Shared\Parser;

class ParserTest extends TestCase
{
    public function testInstance()
    {
        $parser = new Parser();
        $this->assertInstanceOf(Parser::class, $parser);
    }
}
