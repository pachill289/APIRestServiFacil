<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Exception\HttpNotFoundException;
use Slim\Exception\HttpMethodNotAllowedException;

class ErrorHandlers
{
    public static function register(App $app)
    {
        $errorMiddleware = $app->addErrorMiddleware(true, true, true);

        // Manejador para errores 404
        $errorMiddleware->setDefaultErrorHandler(function (
            Request $request,
            Throwable $exception,
            bool $displayErrorDetails
        ) use ($app): Response {
            $response = $app->getResponseFactory()->createResponse();
            
            if ($exception instanceof HttpNotFoundException) {
                $response->getBody()->write("La ruta solicitada '{$request->getUri()->getPath()}' no fue encontrada.");
                return $response->withStatus(404);
            }
            
            if ($exception instanceof HttpMethodNotAllowedException) {
                $allowedMethods = implode(', ', $exception->getAllowedMethods());
                $response->getBody()->write("Método no permitido. Métodos aceptados: {$allowedMethods}");
                return $response->withStatus(405);
            }
            
            // Error genérico
            error_log($exception->getMessage());
            $response->getBody()->write("Ocurrió un error inesperado: ".$exception->getMessage());
            return $response->withStatus(500);
        });
    }
}