<?php

namespace Shared;

class Number
{
    public const SCANNING = 0;
    public const CHARACTERISTIC = 1;
    public const CHARACTERISTIC_DIGIT = 2;
    public const DECIMAL_POINTS = 3;
    public const MANTISSA = 4;
    public const EXPONENT = 5;
    public const EXPONENT_SIGN = 6;
    public const EXPONENT_FIRST_DIGIT = 7;
    public const EXPONENT_DIGITS = 8;
    public const END = 9;

    public static function parse($number, $delimiters = "/[ \n\r\t]/")
    {
        $mode = self::SCANNING;
        $pos = 0;
        $token = null;
        $value_as_string = '';

        while ($pos < strlen($number) && $mode != self::END) {
            $ch = substr($number, $pos, 1);

            switch ($mode) {
                case self::SCANNING:
                    if (preg_match("/[ \n\r\t]/", $ch)) {
                        $pos++;
                    } elseif ($ch === '-') {
                        $value_as_string .= '-';
                        $pos++;
                    }
                    $mode = self::CHARACTERISTIC;
                    break;

                case self::CHARACTERISTIC:
                    if ($ch === '0') {
                        $value_as_string .= $ch;
                        $pos++;
                        $mode = self::DECIMAL_POINTS;
                    } elseif (preg_match("/[1-9]/", $ch)) {
                        $value_as_string .= $ch;
                        $pos++;
                        $mode = self::CHARACTERISTIC_DIGIT;
                    } else {
                        throw new \Exception("Expected digit, actual '" . $ch . "'");
                    }
                    break;

                case self::CHARACTERISTIC_DIGIT:
                    if (preg_match("/\d/", $ch)) {
                        $value_as_string .= $ch;
                        $pos++;
                    } elseif ($delimiters !== null && preg_match($delimiters, $ch)) {
                        $mode = self::END;
                    } else {
                        $mode = self::DECIMAL_POINTS;
                    }
                    break;

                case self::DECIMAL_POINTS:
                    if ($ch === '.') {
                        $value_as_string .= $ch;
                        $pos++;
                        $mode = self::MANTISSA;
                    } elseif ($ch === 'e' || $ch === 'E') {
                        $mode = self::EXPONENT;
                    } elseif ($delimiters !== null && preg_match($delimiters, $ch)) {
                        $mode = self::END;
                    } else {
                        $mode = self::END;
                    }
                    break;

                case self::MANTISSA:
                    if (preg_match("/\d/", $ch)) {
                        $value_as_string .= $ch;
                        $pos++;
                    } elseif ($ch === 'e' || $ch === 'E') {
                        $mode = self::EXPONENT;
                    } elseif ($delimiters !== null && preg_match($delimiters, $ch)) {
                        $mode = self::END;
                    } else {
                        throw new \Exception("Unexpected character '" . $ch . "'");
                    }
                    break;

                case self::EXPONENT:
                    if ($ch === 'e' || $ch === 'E') {
                        $value_as_string .= $ch;
                        $pos++;
                        $mode = self::EXPONENT_SIGN;
                    } elseif ($delimiters !== null && preg_match($delimiters, $ch)) {
                        $mode = self::END;
                    } else {
                        $mode = self::END;
                    }
                    break;

                case self::EXPONENT_SIGN:
                    if ($ch === '-' || $ch === '+') {
                        $value_as_string .= $ch;
                        $pos++;
                    }
                    $mode = self::EXPONENT_FIRST_DIGIT;
                    break;

                case self::EXPONENT_FIRST_DIGIT:
                    if (preg_match("/\d/", $ch)) {
                        $value_as_string .= $ch;
                        $pos++;
                        $mode = self::EXPONENT_DIGITS;
                    } else {
                        throw new \Exception("Expected digit, actual '" . $ch . "'");
                    }
                    break;

                case self::EXPONENT_DIGITS:
                    if (preg_match("/\d/", $ch)) {
                        $value_as_string .= $ch;
                        $pos++;
                    } elseif ($delimiters !== null && preg_match($delimiters, $ch)) {
                        $mode = self::END;
                    } else {
                        throw new \Exception("Expected digit, actual '" . $ch . "'");
                    }
                    break;

                case self::END:
                    break;

                default:
                    throw new \Exception('Unexpected mode ' . $mode);
            }
        }

        if ($mode === self::CHARACTERISTIC || $mode === self::EXPONENT_FIRST_DIGIT) {
            throw new \Exception('Incomplete expression, mode ' . $mode);
        }

        $token = new NumberToken();
        $token->skip = $pos;
        $token->value = floatval($value_as_string);
        $token->value_as_string = $value_as_string;
        return $token;
    }
}
