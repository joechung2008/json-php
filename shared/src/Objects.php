<?php

namespace Shared;

require_once "Types.php";
require_once "Pair.php";

class Objects
{
    public const SCANNING = 0;
    public const PAIR = 1;
    public const COMMA = 2;
    public const END = 3;

    public static function parse($object)
    {
        $mode = self::SCANNING;
        $pos = 0;
        $members = [];

        while ($pos < strlen($object) && $mode != self::END) {
            $ch = substr($object, $pos, 1);

            switch ($mode) {
                case self::SCANNING:
                    if (preg_match("/[ \n\r\t]/", $ch)) {
                        $pos++;
                    } elseif ($ch === '{') {
                        $pos++;
                        $mode = self::PAIR;
                    } else {
                        throw new \Exception("Expected '{', actual '" . $ch . "'");
                    }
                    break;

                case self::PAIR:
                    if (preg_match("/[ \n\r\t]/", $ch)) {
                        $pos++;
                    } elseif ($ch === '}') {
                        if (count($members) > 0) {
                            throw new \Exception("Unexpected ','");
                        }
                        $pos++;
                        $mode = self::END;
                    } else {
                        $slice = substr($object, $pos);
                        $member = Pair::parse($slice);
                        $members[] = $member;
                        $pos += $member->skip;
                        $mode = self::COMMA;
                    }
                    break;

                case self::COMMA:
                    if (preg_match("/[ \n\r\t]/", $ch)) {
                        $pos++;
                    } elseif ($ch === ',') {
                        $pos++;
                        $mode = self::PAIR;
                    } elseif ($ch === '}') {
                        $pos++;
                        $mode = self::END;
                    } else {
                        throw new \Exception("Expected ',' or '}', actual '" . $ch . "'");
                    }
                    break;

                case self::END:
                    break;

                default:
                    throw new \Exception('Unexpected mode ' . $mode);
            }
        }

        $token = new ObjectToken();
        $token->skip = $pos;
        $token->members = $members;
        return $token;
    }
}
