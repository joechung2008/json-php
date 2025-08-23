<?php

use PHPUnit\Framework\TestCase;
use Shared\Parser;

class ObjectsTest extends TestCase
{
    public function testParseEmptyObject()
    {
        $token = Parser::parse('{}');
        $this->assertInstanceOf(\Shared\ObjectToken::class, $token);
        $this->assertEquals(0, count($token->members));
    }

    public function testParseSimpleObject()
    {
        $token = Parser::parse('{"a":1}');
        $this->assertInstanceOf(\Shared\ObjectToken::class, $token);
        $this->assertEquals(1, count($token->members));
        $pair = $token->members[0];
        $this->assertEquals("a", $pair->key->value);
        $this->assertEquals(1, $pair->value->value);
    }

    public function testParseMultiplePairs()
    {
        $token = Parser::parse('{"x":10,"y":20}');
        $this->assertInstanceOf(\Shared\ObjectToken::class, $token);
        $this->assertEquals(2, count($token->members));
        $this->assertEquals("x", $token->members[0]->key->value);
        $this->assertEquals(10, $token->members[0]->value->value);
        $this->assertEquals("y", $token->members[1]->key->value);
        $this->assertEquals(20, $token->members[1]->value->value);
    }

    public function testParseNestedObject()
    {
        $token = Parser::parse('{"obj":{"b":2}}');
        $this->assertInstanceOf(\Shared\ObjectToken::class, $token);
        $this->assertEquals(1, count($token->members));
        $this->assertEquals("obj", $token->members[0]->key->value);
        $nested = $token->members[0]->value;
        $this->assertInstanceOf(\Shared\ObjectToken::class, $nested);
        $this->assertEquals(1, count($nested->members));
        $this->assertEquals("b", $nested->members[0]->key->value);
        $this->assertEquals(2, $nested->members[0]->value->value);
    }

    public function testParseObjectWithArray()
    {
        $token = Parser::parse('{"arr":[1,2,3]}');
        $this->assertInstanceOf(\Shared\ObjectToken::class, $token);
        $this->assertEquals(1, count($token->members));
        $this->assertEquals("arr", $token->members[0]->key->value);
        $arrayToken = $token->members[0]->value;
        $this->assertInstanceOf(\Shared\ArrayToken::class, $arrayToken);
        $this->assertEquals([1,2,3], array_map(function ($el) { return $el->value; }, $arrayToken->elements));
    }

    public function testParseObjectNumbersWithBraces()
    {
        $token = Parser::parse('{"a":42}');
        $this->assertInstanceOf(\Shared\ObjectToken::class, $token);
        $this->assertEquals(1, count($token->members));
        $this->assertEquals("a", $token->members[0]->key->value);
        $this->assertEquals(42, $token->members[0]->value->value);
    }

    public function testParseObjectNumbersWithCommas()
    {
        $token = Parser::parse('{"x":7,"y":8,"z":9}');
        $this->assertInstanceOf(\Shared\ObjectToken::class, $token);
        $this->assertEquals(3, count($token->members));
        $this->assertEquals(["x","y","z"], array_map(function ($pair) {return $pair->key->value;}, $token->members));
        $this->assertEquals([7,8,9], array_map(function ($pair) {return $pair->value->value;}, $token->members));
    }

    public function testParseObjectNumbersWithWhitespaceAndDelimiters()
    {
        $token = Parser::parse('{ "a" : 3 , "b" : 4 , "c" : 5 }');
        $this->assertInstanceOf(\Shared\ObjectToken::class, $token);
        $this->assertEquals(3, count($token->members));
        $this->assertEquals(["a","b","c"], array_map(function ($pair) {return $pair->key->value;}, $token->members));
        $this->assertEquals([3,4,5], array_map(function ($pair) {return $pair->value->value;}, $token->members));
    }
}
