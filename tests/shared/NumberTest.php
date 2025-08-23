<?php

use PHPUnit\Framework\TestCase;
use Shared\Parser;

class NumberTest extends TestCase
{
    public function testParseInteger()
    {
        $token = Parser::parse("42");
        $this->assertEquals(42.0, $token->value);
        $this->assertEquals("42", $token->value_as_string);
    }

    public function testParseNegativeInteger()
    {
        $token = Parser::parse("-7");
        $this->assertEquals(-7.0, $token->value);
        $this->assertEquals("-7", $token->value_as_string);
    }

    public function testParseFloat()
    {
        $token = Parser::parse("3.14");
        $this->assertEquals(3.14, $token->value);
        $this->assertEquals("3.14", $token->value_as_string);
    }

    public function testParseNegativeFloat()
    {
        $token = Parser::parse("-0.99");
        $this->assertEquals(-0.99, $token->value);
        $this->assertEquals("-0.99", $token->value_as_string);
    }

    public function testParseExponent()
    {
        $token = Parser::parse("1e10");
        $this->assertEquals(1e10, $token->value);
        $this->assertEquals("1e10", $token->value_as_string);

        $token = Parser::parse("2.5E-3");
        $this->assertEquals(2.5e-3, $token->value);
        $this->assertEquals("2.5E-3", $token->value_as_string);

        $token = Parser::parse("-6.022e23");
        $this->assertEquals(-6.022e23, $token->value);
        $this->assertEquals("-6.022e23", $token->value_as_string);
    }

    public function testParseLeadingZero()
    {
        $token = Parser::parse("0.1");
        $this->assertEquals(0.1, $token->value);
        $this->assertEquals("0.1", $token->value_as_string);
    }
}
