<?php


namespace App\Controller;

use Symfony\Bundle\TwigBundle\Controller\ExceptionController as TwigExceptionController;
use Symfony\Component\Debug\Exception\FlattenException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Log\DebugLoggerInterface;
use Twig\Environment;

class CustomExceptionController extends TwigExceptionController
{
    public function __construct(Environment $twig, bool $debug)
    {
        parent::__construct($twig, $debug);
    }

    public function showAction(Request $request, FlattenException $exception, DebugLoggerInterface $logger = null)
    {
        $code = $exception->getStatusCode();
        return new Response( json_encode(
            [
                'status_code' => $code,
                'status_text' => isset(Response::$statusTexts[$code]) ? Response::$statusTexts[$code] : '',
            ]
        ), 200, ['Content-Type' => 'application/json']);
    }
}
