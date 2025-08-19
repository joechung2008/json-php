<?php

use PHPUnit\Framework\TestCase;
use Shared\Number;

class NumberTest extends TestCase
{
    public function testInstance()
    {
        $number = new Number();
        $this->assertInstanceOf(Number::class, $number);
    }

    public function testParseInteger()
    {
        $token = Number::parse("42");
        $this->assertEquals(42.0, $token->value);
        $this->assertEquals("42", $token->value_as_string);
    }

    public function testParseNegativeInteger()
    {
        $token = Number::parse("-7");
        $this->assertEquals(-7.0, $token->value);
        $this->assertEquals("-7", $token->value_as_string);
    }

    public function testParseFloat()
    {
        $token = Number::parse("3.14");
        $this->assertEquals(3.14, $token->value);
        $this->assertEquals("3.14", $token->value_as_string);
    }

    public function testParseNegativeFloat()
    {
        $token = Number::parse("-0.99");
        $this->assertEquals(-0.99, $token->value);
        $this->assertEquals("-0.99", $token->value_as_string);
    }

    public function testParseExponent()
    {
        $token = Number::parse("1e10");
        $this->assertEquals(1e10, $token->value);
        $this->assertEquals("1e10", $token->value_as_string);

        $token = Number::parse("2.5E-3");
        $this->assertEquals(2.5e-3, $token->value);
        $this->assertEquals("2.5E-3", $token->value_as_string);

        $token = Number::parse("-6.022e23");
        $this->assertEquals(-6.022e23, $token->value);
        $this->assertEquals("-6.022e23", $token->value_as_string);
    }

    public function testParseLeadingZero()
    {
        $token = Number::parse("0.1");
        $this->assertEquals(0.1, $token->value);
        $this->assertEquals("0.1", $token->value_as_string);
    }
}
