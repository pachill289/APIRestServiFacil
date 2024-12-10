<?php

declare(strict_types=1);

use Slim\Factory\AppFactory;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Controllers\UsuarioController;
use App\Controllers\PublicacionController;

require __DIR__ . '/../vendor/autoload.php';

// Incluye la configuración de la base de datos
require __DIR__ . '/../config/database.php';

// Manejo de excepciones de rutas no encontradas y otros errores y excepciones a nivel de API
require __DIR__ . '/../src/err/ErrorHandlers.php';

$app = AppFactory::create();

// Registrar el middleware para menejar solicitudes POST
$app->addBodyParsingMiddleware();

// Registrar eL manejador de errores
ErrorHandlers::register($app);

// ruta bienvenida
$app->get('/', function (Request $request, Response $response) {
    $response->getBody()->write("APIRestServiFacil V1.0");

    return $response;
});


// Rutas para usuarios 
$app->post('/api/usuario/crear', [UsuarioController::class, 'crear']); 
$app->get('/api/usuarios', [UsuarioController::class, 'obtenerTodos']); 
$app->get('/api/usuarios/{id}', [UsuarioController::class, 'obtenerPorId']); 

// Rutas para publicaciones 
$app->post('/api/publicacion/crear', [PublicacionController::class, 'crear']); 
$app->get('/api/publicaciones', [PublicacionController::class, 'obtenerTodas']); 
$app->get('/api/publicaciones/{id}', [PublicacionController::class, 'obtenerPorId']);

$app->run();

?>