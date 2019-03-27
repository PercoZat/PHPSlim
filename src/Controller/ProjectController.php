<?php
namespace App\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;

class ProjectController
{
    private $twig;

    public function __construct(Twig $twig)
    {
        $this->twig = $twig;
    }

    public function show(ServerRequestInterface $request, ResponseInterface $response, ?array $args): ResponseInterface
    {
        return $this->twig->render($response, 'projets/show.twig');
    }

    public function create(ServerRequestInterface $request, ResponseInterface $response, ?array $args): ResponseInterface
    {
        return $this->twig->render($response, 'projets/create.twig');
    }
}
