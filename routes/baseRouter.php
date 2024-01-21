<?php
use Slim\Routing\RouteCollectorProxy;

// Supposons que $app est l'instance de l'application Slim créée ailleurs

// Groupe de routes pour les utilisateurs
$app->group('/users', function (RouteCollectorProxy $group) {
    $group->post('/register', 'UserController:register');
    $group->post('/login', 'UserController:login');
    $group->get('/profile', 'UserController:getUserProfile')->add('verifyToken');
    $group->put('/profile', 'UserController:updateUserProfile')->add('verifyToken');
    // D'autres routes pour les utilisateurs...
});

// Groupe de routes pour les rôles
$app->group('/roles', function (RouteCollectorProxy $group) {
    $group->get('/', 'RoleController:getAllRoles');
    // D'autres routes pour les rôles...
});

// Groupe de routes pour les garde-mangers
$app->group('/gardeMangers', function (RouteCollectorProxy $group) {
    $group->get('/', 'GardeMangerController:obtenirContenu')->add('verifyToken');
    $group->post('/ajouter', 'GardeMangerController:ajouterAliment')->add('verifyToken');
    // D'autres routes pour les garde-mangers...
});

// Groupe de routes pour les aliments
$app->group('/aliments', function (RouteCollectorProxy $group) {
    $group->get('', 'AlimentController:getAllAliments')->add('verifyToken');
    $group->get('/{id}', 'AlimentController:getAlimentById')->add('verifyToken');
    $group->post('', 'AlimentController:createAliment')->add('verifyToken');
    $group->put('/{id}', 'AlimentController:updateAliment')->add('verifyToken');
    $group->delete('/{id}', 'AlimentController:deleteAliment')->add('verifyToken');
});

// Groupe de routes pour les ingrédients de recettes
$app->group('/ingredientsRecettes', function (RouteCollectorProxy $group) {
    // Définissez ici les routes spécifiques aux ingrédients de recettes
});

// Groupe de routes pour les recettes
$app->group('/recettes', function (RouteCollectorProxy $group) {
    // Définissez ici les routes spécifiques aux recettes
});

// Groupe de routes pour les étapes
$app->group('/etapes', function (RouteCollectorProxy $group) {
    // Définissez ici les routes spécifiques aux étapes
});

// Groupe de routes pour les images
$app->group('/images', function (RouteCollectorProxy $group) {
    $group->post('/upload', 'ImageController:uploadImage');
    // D'autres routes pour les images...
});

// Middleware d'erreur
$app->addErrorMiddleware(true, true, true);
