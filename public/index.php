<?php

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$app = new App();

$app->get('/', function(ServerRequestInterface $request, ResponseInterface $response, ?array $args){
    return $response->getBody()->write('<h1>Home Page</p>');
})->setName('Homepage');


//Création d'un groupe de route

$app->group('/projet', function () {
    //Création d'une route
    $this->get('/{id:\d+}', function (ServerRequestInterface $request, ResponseInterface $response, ?array $args) {
        return $response->getBody()->write('<h1>Bonjour</p>');
    })->setName('homepage');

    $this->get('/creation', function (ServerRequestInterface $request, ResponseInterface $response, ?array $args) {
        return $response->getBody()->write('<h1>Création d\'un projet</p>');
    })->setName('app_project_show');
});


$app->run();
