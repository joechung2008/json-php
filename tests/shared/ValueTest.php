<?php

use PHPUnit\Framework\TestCase;
use Shared\Value;

class ValueTest extends TestCase
{
    public function testInstance()
    {
        $value = new Value();
        $this->assertInstanceOf(Value::class, $value);
    }

    public function testParseTrue()
    {
        $token = Value::parse('true');
        $this->assertInstanceOf(\Shared\TrueToken::class, $token);
        $this->assertTrue($token->value);
    }

    public function testParseFalse()
    {
        $token = Value::parse('false');
        $this->assertInstanceOf(\Shared\FalseToken::class, $token);
        $this->assertFalse($token->value);
    }

    public function testParseNull()
    {
        $token = Value::parse('null');
        $this->assertInstanceOf(\Shared\NullToken::class, $token);
        $this->assertNull($token->value);
    }
}
