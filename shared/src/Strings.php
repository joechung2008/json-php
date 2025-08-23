<?php

namespace Shared;

class Strings
{
    public const SCANNING = 0;
    public const LEFT_QUOTE = 1;
    public const CHAR = 2;
    public const ESCAPED_CHAR = 3;
    public const UNICODE = 4;
    public const END = 5;

    public static function parse($string)
    {
        $mode = self::SCANNING;
        $pos = 0;
        $value = null;

        while ($pos < strlen($string) && $mode != self::END) {
            $ch = substr($string, $pos, 1);

            switch ($mode) {
                case self::SCANNING:
                    if (preg_match("/[ \n\r\t]/", $ch)) {
                        $pos++;
                    } elseif ($ch === '"') {
                        $mode = self::LEFT_QUOTE;
                    } else {
                        throw new \Exception("Expected '\"', actual '" . $ch . "'");
                    }
                    break;

                case self::LEFT_QUOTE:
                    if ($ch === '"') {
                        $value = "";
                        $pos++;
                        $mode = self::CHAR;
                    } else {
                        throw new \Exception("Expected '\"', actual '" . $ch . "'");
                    }
                    break;

                case self::CHAR:
                    if ($ch === '\\') {
                        $pos++;
                        $mode = self::ESCAPED_CHAR;
                    } elseif ($ch === '"') {
                        $pos++;
                        $mode = self::END;
                    } elseif ($ch !== '\n' && $ch !== '\r') {
                        $value .= $ch;
                        $pos++;
                    } else {
                        throw new \Exception("Unexpected character '" . $ch . "'");
                    }
                    break;

                case self::ESCAPED_CHAR:
                    if ($ch === "\\" || $ch === '"' || $ch === '/') {
                        $value .= $ch;
                        $pos++;
                        $mode = self::CHAR;
                    } elseif ($ch === 'b') {
                        $value .= "\b";
                        $pos++;
                        $mode = self::CHAR;
                    } elseif ($ch === 'f') {
                        $value .= "\f";
                        $pos++;
                        $mode = self::CHAR;
                    } elseif ($ch === 'n') {
                        $value .= "\n";
                        $pos++;
                        $mode = self::CHAR;
                    } elseif ($ch === 'r') {
                        $value .= "\r";
                        $pos++;
                        $mode = self::CHAR;
                    } elseif ($ch === 't') {
                        $value .= "\t";
                        $pos++;
                        $mode = self::CHAR;
                    } elseif ($ch === 'u') {
                        $pos++;
                        $mode = self::UNICODE;
                    }
                    break;

                case self::UNICODE:
                    $slice = substr($string, $pos, 4);
                    if (preg_match('/[0-9a-fA-F]{4}/', $slice)) {
                        $value .= "\\u" . $slice;
                        $pos += 4;
                        $mode = self::CHAR;
                    } else {
                        throw new \Exception("Invalid hexadecimal code " . $slice);
                    }
                    break;

                case self::END:
                    break;

                default:
                    throw new \Exception('Unexpected mode ' . $mode);
            }
        }

        $token = new StringToken();
        $token->skip = $pos;
        $token->value = $value;
        return $token;
    }
}
