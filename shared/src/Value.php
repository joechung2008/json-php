<?php

namespace Shared;

class Value
{
    public const SCANNING = 0;
    public const ARRAYS = 1;
    public const FALSES = 2;
    public const NULLS = 3;
    public const NUMBER = 4;
    public const OBJECTS = 5;
    public const STRINGS = 6;
    public const TRUES = 7;
    public const END = 8;

    public static function parse(string $value, ?string $delimiters = null)
    {
        $mode = self::SCANNING;
        $pos = 0;

        while ($pos < strlen($value) && $mode != self::END) {
            $ch = substr($value, $pos, 1);

            switch ($mode) {
                case self::SCANNING:
                    if (preg_match('/[ \n\r\t]/', $ch)) {
                        $pos++;
                    } elseif ($ch === '[') {
                        $mode = self::ARRAYS;
                    } elseif ($ch === 'f') {
                        $mode = self::FALSES;
                    } elseif ($ch === 'n') {
                        $mode = self::NULLS;
                    } elseif (preg_match('/[-\d]/', $ch)) {
                        $mode = self::NUMBER;
                    } elseif ($ch === '{') {
                        $mode = self::OBJECTS;
                    } elseif ($ch === '"') {
                        $mode = self::STRINGS;
                    } elseif ($ch === 't') {
                        $mode = self::TRUES;
                    } elseif ($delimiters != null && strpos($delimiters, $ch) !== false) {
                        $mode = self::END;
                    } else {
                        throw new \Exception("Unexpected character '" . $ch . "'");
                    }
                    break;

                case self::ARRAYS:
                    $slice = substr($value, $pos);
                    $array = Arrays::parse($slice);
                    $array->skip += $pos;
                    return $array;

                case self::FALSES:
                    $slice = substr($value, $pos, 5);
                    if ($slice === 'false') {
                        $false = new FalseToken();
                        $false->skip = $pos + 5;
                        $false->value = false;
                        return $false;
                    } else {
                        throw new \Exception("Expected 'false', actual '" . $slice . "'");
                    }
                    break;

                case self::NULLS:
                    $slice = substr($value, $pos, 4);
                    if ($slice === 'null') {
                        $null = new NullToken();
                        $null->skip = $pos + 4;
                        return $null;
                    } else {
                        throw new \Exception("Expected 'null', actual '" . $slice . "'");
                    }
                    break;

                case self::NUMBER:
                    $slice = substr($value, $pos);
                    $number = Number::parse($slice, $delimiters);
                    $number->skip += $pos;
                    return $number;

                case self::OBJECTS:
                    $slice = substr($value, $pos);
                    $object = Objects::parse($slice);
                    $object->skip += $pos;
                    return $object;

                case self::STRINGS:
                    $slice = substr($value, $pos);
                    $string = Strings::parse($slice);
                    $string->skip += $pos;
                    return $string;

                case self::TRUES:
                    $slice = substr($value, $pos, 4);
                    if ($slice === "true") {
                        $true = new TrueToken();
                        $true->skip = $pos + 4;
                        $true->value = true;
                        return $true;
                    } else {
                        throw new \Exception("Expected 'true', actual '" . $slice . "'");
                    }
                    break;

                case self::END:
                    break;

                default:
                    throw new \Exception('Unexpected mode ' . $mode);
            }
        }

        throw new \Exception('$value cannot be empty');
    }
}
