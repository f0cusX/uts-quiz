<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController
{
    /**
     * @Route("/", name="default")
     */
    public function __invoke(): Response
    {
        return new Response(
            '<!DOCTYPE html>
            <html lang="ru">
            <head>
                <title>UTS QUIZ API</title>
                <meta charset="utf-8"/>
                <meta name="viewport" content="width=device-width, initial-scale=1">
            </head>
            <body>
                <redoc spec-url="api.yaml"></redoc>
                <script src="redoc.standalone.js"></script>
            </body>
            </html>'
        );
    }
}
