<?php

namespace Shared;

class Pair
{
    public const SCANNING = 0;
    public const KEY = 1;
    public const COLON = 2;
    public const VALUE = 3;
    public const END = 4;

    public static function parse($pair)
    {
        $mode = self::SCANNING;
        $pos = 0;

        while ($pos < strlen($pair) && $mode != self::END) {
            $ch = substr($pair, $pos, 1);

            switch ($mode) {
                case self::SCANNING:
                    if (preg_match("/[ \n\r\t]/", $ch)) {
                        $pos++;
                    } else {
                        $mode = self::KEY;
                    }
                    break;

                case self::KEY:
                    $slice = substr($pair, $pos);
                    $key = Strings::parse($slice);
                    $pos += $key->skip;
                    $mode = self::COLON;
                    break;

                case self::COLON:
                    if (preg_match("/[ \n\r\t]/", $ch)) {
                        $pos++;
                    } elseif ($ch === ':') {
                        $pos++;
                        $mode = self::VALUE;
                    } else {
                        throw new \Exception("Expected ':', actual '" . $ch . "'");
                    }
                    break;

                case self::VALUE:
                    $slice = substr($pair, $pos);
                    $value = Value::parse($slice, "[ \n\r\t},]");
                    $pos += $value->skip;
                    $mode = self::END;
                    break;

                case self::END:
                    break;

                default:
                    throw new \Exception('Unexpected mode ' . $mode);
            }
        }

        $token = new PairToken();
        $token->skip = $pos;
        $token->key = $key;
        $token->value = $value;
        return $token;
    }
}
