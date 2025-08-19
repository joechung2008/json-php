<?php

use PHPUnit\Framework\TestCase;
use Shared\Objects;
use Shared\Types;

class ObjectsTest extends TestCase
{
    public function testInstance()
    {
        $objects = new Objects();
        $this->assertInstanceOf(Objects::class, $objects);
    }

    public function testParseEmptyObject()
    {
        $token = Objects::parse('{}');
        $this->assertInstanceOf(\Shared\ObjectToken::class, $token);
        $this->assertEquals(0, count($token->members));
    }

    public function testParseSimpleObject()
    {
        $token = Objects::parse('{"a":1}');
        $this->assertInstanceOf(\Shared\ObjectToken::class, $token);
        $this->assertEquals(1, count($token->members));
        $pair = $token->members[0];
        $this->assertEquals("a", $pair->key->value);
        $this->assertEquals(1, $pair->value->value);
    }

    public function testParseMultiplePairs()
    {
        $token = Objects::parse('{"x":10,"y":20}');
        $this->assertInstanceOf(\Shared\ObjectToken::class, $token);
        $this->assertEquals(2, count($token->members));
        $this->assertEquals("x", $token->members[0]->key->value);
        $this->assertEquals(10, $token->members[0]->value->value);
        $this->assertEquals("y", $token->members[1]->key->value);
        $this->assertEquals(20, $token->members[1]->value->value);
    }

    public function testParseNestedObject()
    {
        $token = Objects::parse('{"obj":{"b":2}}');
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
        $token = Objects::parse('{"arr":[1,2,3]}');
        $this->assertInstanceOf(\Shared\ObjectToken::class, $token);
        $this->assertEquals(1, count($token->members));
        $this->assertEquals("arr", $token->members[0]->key->value);
        $arrayToken = $token->members[0]->value;
        $this->assertInstanceOf(\Shared\ArrayToken::class, $arrayToken);
        $this->assertEquals([1,2,3], array_map(function ($el) { return $el->value; }, $arrayToken->elements));
    }
}
