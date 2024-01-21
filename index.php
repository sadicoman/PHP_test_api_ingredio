<?php
require 'vendor/autoload.php';
require_once 'config.php';
require_once 'dbUtils.php';

// Initialisation de la base de données
$db = new DbUtils();
$db->testDbConnection();
$db->syncDb();

// Configuration de CORS
header("Access-Control-Allow-Origin: http://127.0.0.1:5173");
header("Access-Control-Allow-Origin: http://localhost:5173");
header('Content-Type: application/json');

// Routage
$request = $_SERVER['REQUEST_URI'];
switch ($request) {
    case '/':
        require __DIR__ . '/routes/baseRouter.php';
        break;
    // Vous pouvez ajouter d'autres cas pour d'autres routes ici
    default:
        http_response_code(404);
        echo json_encode(['error' => 'Not Found']);
        break;
}
