<?php

use App\Controller\AboutController;
use App\Controller\ContactController;
use App\Controller\HomeController;
use App\Controller\ProjectController;
use Generic\Database\Connection;
use Psr\Container\ContainerInterface;
use Slim\App;

require_once dirname(__DIR__) . '/vendor/autoload.php';

//______________________________________________________________________________________________________________________Configuration pour afficher les erreurs de Slim
$config = [
    'settings' => [
        'displayErrorDetails' => true
    ]
];
//______________________________________________________________________________________________________________________CONNECTION BDD
$bdd = new Connection('portfolio_projet','root', '');
//______________________________________________________________________________________________________________________Recup table

$req = $bdd->findTable('listeprojets');


//______________________________________________________________________________________________________________________APP
$app = new App($config);

//______________________________________________________________________________________________________________________TWIG Container d'injection de dépendance
$container = $app->getContainer();
// Register component on container
$container['view'] = function (ContainerInterface $container) {
    $view = new \Slim\Views\Twig(dirname(__DIR__) . '/templates', [
        'cache' => false
    ]);
    // Instantiate and add Slim specific extension
    $router = $container->get('router');
    $uri = \Slim\Http\Uri::createFromEnvironment(new \Slim\Http\Environment($_SERVER));
    $view->addExtension(new Slim\Views\TwigExtension($router, $uri));
    return $view;
};
//______________________________________________________________________________________________________________________Boucle pour Container d'injection de dépendance
$tab = [HomeController::class,
        ContactController::class,
        AboutController::class,
        ProjectController::class,
];

foreach ($tab as $key) {
    $container[$key] = function (ContainerInterface $container)use($key) {
        return new $key($container->get('view'));
    };
}

//______________________________________________________________________________________________________________________ROUTE Index
$app->get('/', HomeController::class .':home')->setName('Homepage');
//______________________________________________________________________________________________________________________ROUTE Contact
$app->get('/contact', ContactController::class .':contact')->setName('Contact');
//______________________________________________________________________________________________________________________ROUTE About
$app->get('/about', AboutController::class .':about')->setName('A propos');

//______________________________________________________________________________________________________________________GROUPE de routes /projets
$app->group('/projets', function () {
    $this->get('/{id:\d+}', ProjectController::class . ':show')->setName('app_project_show');
    $this->get('/create', ProjectController::class . ':create')->setName('app_project_create');
});





$app->run();
