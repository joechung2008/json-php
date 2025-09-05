<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Shared\Parser;

class ParseController extends AbstractController
{
    #[Route('/api/v1/parse', name: 'api_parse', methods: ['POST'])]
    public function parse(Request $request): JsonResponse
    {
        if ($request->headers->get('Content-Type') !== 'text/plain') {
            return new JsonResponse([
                'code' => 415,
                'message' => 'Unsupported Media Type'
            ], 415);
        }

        try {
            $input = $request->getContent();
            $parsed = Parser::parse($input);
            return new JsonResponse($parsed, 200);
        } catch (\Exception $e) {
            return new JsonResponse([
                'code' => 400,
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
