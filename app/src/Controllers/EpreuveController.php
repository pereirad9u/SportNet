<?php
/**
 * Created by PhpStorm.
 * User: debian
 * Date: 15/11/16
 * Time: 10:32
 */

namespace App\Controllers;

use Psr\Log\LoggerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class EpreuveController
{
    private $view;
    private $logger;
    private $router;

    public function __construct($c)
    {
        $this->view = $c->get('view');
        $this->logger = $c->get('logger');
        $this->router = $c->get('router');
    }

    public function dispatch(Request $request, Response $response, $args) {

        return $this->view->render($response, 'epreuve.twig', []);
    }

    public function creationEpreuve(Request $request, Response $response, $args) {
        return $this->view->render($response, 'creationEpreuve.twig', []);
    }
}