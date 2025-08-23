<?php

namespace Shared;

class Arrays
{
    public const SCANNING = 0;
    public const LEFT_BRACKET = 1;
    public const ELEMENT = 2;
    public const COMMA = 3;
    public const END = 4;

    public static function parse(string $array)
    {
        $mode = self::SCANNING;
        $pos = 0;
        $elements = [];

        while ($pos < strlen($array) && $mode != self::END) {
            $ch = substr($array, $pos, 1);

            switch ($mode) {
                case self::SCANNING:
                    if (preg_match("/[ \n\r\t]/", $ch)) {
                        $pos++;
                    } elseif ($ch === '[') {
                        $elements = [];
                        $pos++;
                        $mode = self::ELEMENT;
                    } else {
                        throw new \Exception("Expected '[', actual '" . $ch . "'");
                    }
                    break;

                case self::ELEMENT:
                    if (preg_match("/[ \n\r\t]/", $ch)) {
                        $pos++;
                    } elseif ($ch === ']') {
                        if (count($elements) > 0) {
                            throw new \Exception("Unexpected ','");
                        }

                        $pos++;
                        $mode = self::END;
                    } else {
                        $slice = substr($array, $pos);
                        $element = Value::parse($slice, "[ \n\r\t\],]");
                        $elements[] = $element;
                        $pos += $element->skip;
                        $mode = self::COMMA;
                    }
                    break;

                case self::COMMA:
                    if (preg_match("/[ \n\r\t]/", $ch)) {
                        $pos++;
                    } elseif ($ch === ',') {
                        $pos++;
                        $mode = self::ELEMENT;
                    } elseif ($ch === ']') {
                        $pos++;
                        $mode = self::END;
                    } else {
                        throw new \Exception("Expected ',' or ']', actual '" . $ch . "'");
                    }
                    break;

                case self::END:
                    break;

                default:
                    throw new \Exception('Unexpected mode ' . $mode);
            }
        }

        $token = new ArrayToken();
        $token->skip = $pos;
        $token->elements = $elements;
        return $token;
    }
}
