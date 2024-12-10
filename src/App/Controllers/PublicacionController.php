<?php

namespace App\Controllers;

use App\Models\Publicacion;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class PublicacionController {
    public function crear(Request $request, Response $response, array $args) {
        $data = $request->getParsedBody();

        if (empty($data['id_usuario']) || empty($data['titulo_servicio']) || empty($data['tipo']) ||
            empty($data['descripcion']) || empty($data['costo']) || empty($data['fecha_validez'])) {
            $response->getBody()->write(json_encode(['message' => 'Datos incompletos']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }

        $publicacion = Publicacion::create($data);

        $response->getBody()->write(json_encode(['message' => 'Publicación creada con éxito', 'publicacion' => $publicacion]));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
    }

    public function obtenerTodas(Request $request, Response $response, array $args) {
        $publicaciones = Publicacion::all();
        $response->getBody()->write($publicaciones->toJson());
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function obtenerPorId(Request $request, Response $response, array $args) {
        $publicacion = Publicacion::find($args['id']);
        if ($publicacion) {
            $response->getBody()->write($publicacion->toJson());
            return $response->withHeader('Content-Type', 'application/json');
        }
        $response->getBody()->write(json_encode(['message' => 'Publicación no encontrada']));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
    }
}

?>