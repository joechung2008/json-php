<?php

namespace Shared;

class Token
{
    public $skip;
}

class ArrayToken extends Token
{
    public $elements;
}

class FalseToken extends Token
{
    public $value;
}

class NullToken extends Token
{
    public $value;
}

class NumberToken extends Token
{
    public $value;
    public $value_as_string;
}

class ObjectToken extends Token
{
    public $members;
}

class PairToken extends Token
{
    public $key;
    public $value;
}

class StringToken extends Token
{
    public $value;
}

class TrueToken extends Token
{
    public $value;
}
