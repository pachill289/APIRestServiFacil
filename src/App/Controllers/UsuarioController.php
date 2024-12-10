<?php

namespace App\Controllers;

use App\Models\Usuario;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class UsuarioController {
    public function crear(Request $request, Response $response, array $args) {

        $data = $request->getParsedBody();

        if (!$data) {
            $response->getBody()->write(json_encode(['message' => 'JSON inválido']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }
        
        if (empty($data['id']) || empty($data['nombres']) || empty($data['apellidos']) || empty($data['clave']) || empty($data['tipo']) ||
            empty($data['cargo']) || empty($data['correo']) || empty($data['celular']) || empty($data['fecha_nacimiento']) || empty($data['direccion'])) {
            $response->getBody()->write(json_encode(['message' => 'Datos incompletos']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }

        // Encriptar la contraseña 
        $data['clave'] = password_hash($data['clave'], PASSWORD_BCRYPT);

        $usuario = Usuario::create($data);

        $response->getBody()->write(json_encode(['message' => 'Datos', 'usuario' => $usuario]));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
    }

    public function obtenerTodos(Request $request = null, Response $response = null, array $args = null) {
        $usuarios = Usuario::all();
        $response->getBody()->write($usuarios->toJson());
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function obtenerPorId(Request $request, Response $response, array $args) {
        $usuario = Usuario::find($args['id']);
        if ($usuario) {
            $response->getBody()->write($usuario->toJson());
            return $response->withHeader('Content-Type', 'application/json');
        }
        $response->getBody()->write(json_encode(['message' => 'Usuario no encontrado']));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
    }
}
