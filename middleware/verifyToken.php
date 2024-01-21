<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;
use Firebase\JWT\JWT;

require_once 'vendor/autoload.php';

function verifyToken(Request $request, RequestHandler $handler): Response
{
    $response = new Response();
    $token = $request->getHeaderLine('Authorization') ?: $request->getHeaderLine('x-access-token');

    if (empty($token)) {
        $response->getBody()->write(json_encode(['message' => 'Aucun token fourni.']));
        return $response->withStatus(403)->withHeader('Content-Type', 'application/json');
    }

    try {
        $decoded = JWT::decode($token, $_ENV['JWT_SECRET'], ['HS256']);
        $request = $request->withAttribute('userId', $decoded->id);
        return $handler->handle($request);
    } catch (\Exception $e) {
        $response->getBody()->write(json_encode(['message' => 'Non autorisé.']));
        return $response->withStatus(401)->withHeader('Content-Type', 'application/json');
    }
}
