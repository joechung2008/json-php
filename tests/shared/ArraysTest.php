<?php

use PHPUnit\Framework\TestCase;
use Shared\Parser;

class ArraysTest extends TestCase
{
    public function testInstance()
    {
        $parser = new Parser();
        $this->assertInstanceOf(Parser::class, $parser);
    }

    public function testParseEmptyArray()
    {
        $token = Parser::parse('[]');
        $this->assertIsObject($token);
        $this->assertEquals(2, $token->skip);
        $this->assertEquals([], $token->elements);
    }

    public function testParseSingleElementArray()
    {
        $token = Parser::parse('[1]');
        $this->assertCount(1, $token->elements);
    }

    public function testParseMultipleElementsArray()
    {
        $token = Parser::parse('[1, 2, 3]');
        $this->assertCount(3, $token->elements);
    }

    public function testParseNestedArray()
    {
        $token = Parser::parse('[[1,2], [3,4]]');
        $this->assertCount(2, $token->elements);
    }

    public function testParseMixedTypesArray()
    {
        $token = Parser::parse('[1, "a", true, null]');
        $this->assertCount(4, $token->elements);
    }

    public function testParseArrayWithWhitespace()
    {
        $token = Parser::parse("[ 1 , 2 , 3 ]");
        $this->assertCount(3, $token->elements);
    }

    public function testParseArrayNumbersWithBrackets()
    {
        $token = Parser::parse("[42]");
        $this->assertCount(1, $token->elements);
        $this->assertEquals(42, $token->elements[0]->value);
    }

    public function testParseArrayNumbersWithCommas()
    {
        $token = Parser::parse("[7,8,9]");
        $this->assertCount(3, $token->elements);
        $this->assertEquals([7,8,9], array_map(function ($el) {return $el->value;}, $token->elements));
    }

    public function testParseArrayNumbersWithWhitespaceAndDelimiters()
    {
        $token = Parser::parse("[  3 ,  4 ,  5 ]");
        $this->assertCount(3, $token->elements);
        $this->assertEquals([3,4,5], array_map(function ($el) {return $el->value;}, $token->elements));
    }

    public function testParseInvalidArrayThrows()
    {
        $this->expectException(\Exception::class);
        Parser::parse('[1,]');
    }
}
