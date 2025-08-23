<?php

use PHPUnit\Framework\TestCase;
use Shared\Parser;

class PairTest extends TestCase
{
    public function testSimpleStringKeyNumberValue()
    {
        $obj = Parser::parse('{"a":1}');
        $token = $obj->members[0];
        $this->assertEquals("a", $token->key->value);
        $this->assertEquals(1, $token->value->value);
    }

    public function testKeyWithWhitespace()
    {
        $obj = Parser::parse('{   "key with space"   :   42   }');
        $token = $obj->members[0];
        $this->assertEquals("key with space", $token->key->value);
        $this->assertEquals(42, $token->value->value);
    }

    public function testKeyWithEscapedQuote()
    {
        $obj = Parser::parse('{"ke\"y":123}');
        $token = $obj->members[0];
        $this->assertEquals('ke"y', $token->key->value);
        $this->assertEquals(123, $token->value->value);
    }

    public function testUnicodeKey()
    {
        $obj = Parser::parse('{"ключ":7}');
        $token = $obj->members[0];
        $this->assertEquals("ключ", $token->key->value);
        $this->assertEquals(7, $token->value->value);
    }

    public function testStringValue()
    {
        $obj = Parser::parse('{"str":"hello"}');
        $token = $obj->members[0];
        $this->assertEquals("str", $token->key->value);
        $this->assertEquals("hello", $token->value->value);
    }

    public function testBooleanValue()
    {
        $obj = Parser::parse('{"flag":true}');
        $token = $obj->members[0];
        $this->assertEquals("flag", $token->key->value);
        $this->assertTrue($token->value->value);
    }

    public function testNullValue()
    {
        $obj = Parser::parse('{"nothing":null}');
        $token = $obj->members[0];
        $this->assertEquals("nothing", $token->key->value);
        $this->assertNull($token->value->value);
    }

    public function testArrayValue()
    {
        $obj = Parser::parse('{"arr":[1,2]}');
        $token = $obj->members[0];
        $this->assertEquals("arr", $token->key->value);
        $arrayToken = $token->value;
        $this->assertInstanceOf(\Shared\ArrayToken::class, $arrayToken);
        $this->assertEquals([1,2], array_map(function ($el) { return $el->value; }, $arrayToken->elements));
    }

    public function testObjectValue()
    {
        $obj = Parser::parse('{"obj":{"x":5}}');
        $token = $obj->members[0];
        $this->assertEquals("obj", $token->key->value);
        $objectToken = $token->value;
        $this->assertInstanceOf(\Shared\ObjectToken::class, $objectToken);
        $this->assertEquals("x", $objectToken->members[0]->key->value);
        $this->assertEquals(5, $objectToken->members[0]->value->value);
    }
}
