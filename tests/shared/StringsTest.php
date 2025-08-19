<?php

use PHPUnit\Framework\TestCase;
use Shared\Strings;
use Shared\Types;

class StringsTest extends TestCase
{
    public function testInstance()
    {
        $strings = new Strings();
        $this->assertInstanceOf(Strings::class, $strings);
    }

    public function testSimpleString()
    {
        $token = Strings::parse('"hello"');
        $this->assertEquals("hello", $token->value);
    }

    public function testEmptyString()
    {
        $token = Strings::parse('""');
        $this->assertEquals("", $token->value);
    }

    public function testStringWithWhitespace()
    {
        $token = Strings::parse('"  spaced  "');
        $this->assertEquals("  spaced  ", $token->value);
    }

    public function testStringWithEscapedQuote()
    {
        $token = Strings::parse('"he said: \"hi\""');
        $this->assertEquals('he said: "hi"', $token->value);
    }

    public function testStringWithUnicode()
    {
        $token = Strings::parse('"ключ"');
        $this->assertEquals("ключ", $token->value);
    }

    public function testStringWithSpecialCharacters()
    {
        $token = Strings::parse('"!@#$%^&*()"');
        $this->assertEquals("!@#$%^&*()", $token->value);
    }

    public function testStringWithEscapeSequences()
    {
        $token = Strings::parse('"line\\nbreak\\tindent\\\\slash"');
        $this->assertEquals("line\nbreak\tindent\\slash", $token->value);
    }
}
