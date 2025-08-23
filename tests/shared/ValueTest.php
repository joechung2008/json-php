<?php

use PHPUnit\Framework\TestCase;
use Shared\Parser;

class ValueTest extends TestCase
{
    public function testParseTrue()
    {
        $token = Parser::parse('true');
        $this->assertInstanceOf(\Shared\TrueToken::class, $token);
        $this->assertTrue($token->value);
    }

    public function testParseFalse()
    {
        $token = Parser::parse('false');
        $this->assertInstanceOf(\Shared\FalseToken::class, $token);
        $this->assertFalse($token->value);
    }

    public function testParseNull()
    {
        $token = Parser::parse('null');
        $this->assertInstanceOf(\Shared\NullToken::class, $token);
        $this->assertNull($token->value);
    }
}
