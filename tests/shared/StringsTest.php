<?php

use PHPUnit\Framework\TestCase;
use Shared\Parser;

class StringsTest extends TestCase
{
    public function testSimpleString()
    {
        $token = Parser::parse('"hello"');
        $this->assertEquals("hello", $token->value);
    }

    public function testEmptyString()
    {
        $token = Parser::parse('""');
        $this->assertEquals("", $token->value);
    }

    public function testStringWithWhitespace()
    {
        $token = Parser::parse('"  spaced  "');
        $this->assertEquals("  spaced  ", $token->value);
    }

    public function testStringWithEscapedQuote()
    {
        $token = Parser::parse('"he said: \"hi\""');
        $this->assertEquals('he said: "hi"', $token->value);
    }

    public function testStringWithUnicode()
    {
        $token = Parser::parse('"ключ"');
        $this->assertEquals("ключ", $token->value);
    }

    public function testStringWithSpecialCharacters()
    {
        $token = Parser::parse('"!@#$%^&*()"');
        $this->assertEquals("!@#$%^&*()", $token->value);
    }

    public function testStringWithEscapeSequences()
    {
        $token = Parser::parse('"line\\nbreak\\tindent\\\\slash"');
        $this->assertEquals("line\nbreak\tindent\\slash", $token->value);
    }

    public function testStringWithUnicodeEscape()
    {
        $token = Parser::parse('"\\u0048\\u0065\\u006c\\u006c\\u006f"');
        $this->assertEquals("Hello", $token->value);
    }
}
