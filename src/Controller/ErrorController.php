<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
// use Symfony\Component\HttpKernel\Log\DebugLoggerInterface;

class ErrorController extends AbstractController
{
    public function show(\Throwable $exception/* , DebugLoggerInterface $logger = null */): Response
    {
      if ($exception instanceof HttpExceptionInterface && $exception->getStatusCode() === 404) {
        return $this->render('exceptions/404.twig', [
          "title" => "404",
          "description" => "404",
        ]);
      }
      return $this->render('exceptions/default.twig', [
        "title" => "",
        "description" => "",
        'message' => $exception->getMessage(),
      ]);
    }
}