<?php

namespace Shared;

require_once "Value.php";

class Parser
{
    public const SCANNING = 0;
    public const VALUE = 1;
    public const END = 2;

    public static function parse(string $json)
    {
        $mode = self::SCANNING;
        $pos = 0;
        $value = null;

        while ($pos < strlen($json) && $mode != self::END) {
            $ch = substr($json, $pos, 1);

            switch ($mode) {
                case self::SCANNING:
                    if (preg_match("/[ \n\r\t]/", $ch)) {
                        $pos++;
                    } else {
                        $mode = self::VALUE;
                    }
                    break;

                case self::VALUE:
                    $slice = substr($json, $pos);
                    $value = Value::parse($slice, '/[ \n\r\t]/');
                    $pos += $value->skip;
                    $mode = self::END;
                    break;

                case self::END:
                    break;

                default:
                    throw new \Exception('Unexpected mode ' . $mode);
            }
        }

        return $value;
    }
}
