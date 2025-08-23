<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Shared\Parser;

class ParseController extends Controller
{
    public function parse(Request $request)
    {
        if ($request->header('Content-Type') !== 'text/plain') {
            return response()->json([
                'code' => 415,
                'message' => 'Unsupported Media Type'
            ], 415);
        }

        try {
            $input = $request->getContent();
            $parsed = Parser::parse($input);
            return response()->json($parsed, 200);
        } catch (\Exception $e) {
            return response()->json([
                'code' => 400,
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
