<?php

use PHPUnit\Framework\TestCase;
use Shared\Arrays;
use Shared\Types;

class ArraysTest extends TestCase
{
    public function testInstance()
    {
        $arrays = new Arrays();
        $this->assertInstanceOf(Arrays::class, $arrays);
    }

    public function testParseEmptyArray()
    {
        $token = Arrays::parse('[]');
        $this->assertIsObject($token);
        $this->assertEquals(2, $token->skip);
        $this->assertEquals([], $token->elements);
    }

    public function testParseSingleElementArray()
    {
        $token = Arrays::parse('[1]');
        $this->assertCount(1, $token->elements);
    }

    public function testParseMultipleElementsArray()
    {
        $token = Arrays::parse('[1, 2, 3]');
        $this->assertCount(3, $token->elements);
    }

    public function testParseNestedArray()
    {
        $token = Arrays::parse('[[1,2], [3,4]]');
        $this->assertCount(2, $token->elements);
    }

    public function testParseMixedTypesArray()
    {
        $token = Arrays::parse('[1, "a", true, null]');
        $this->assertCount(4, $token->elements);
    }

    public function testParseArrayWithWhitespace()
    {
        $token = Arrays::parse("[ 1 , 2 , 3 ]");
        $this->assertCount(3, $token->elements);
    }

    public function testParseInvalidArrayThrows()
    {
        $this->expectException(\Exception::class);
        Arrays::parse('[1,]');
    }
}
