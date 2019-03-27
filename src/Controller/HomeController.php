<?php
namespace App\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;

class HomeController
{
    private $twig;

    public function __construct(Twig $twig)
    {
        $this->twig = $twig;
    }

    public function home(ServerRequestInterface $request, ResponseInterface $response, ?array $args): ResponseInterface
    {
        return $this->twig->render($response, 'home.twig');
    }
}
