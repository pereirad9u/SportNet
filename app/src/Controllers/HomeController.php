<?php

namespace App\Controllers;

use Psr\Log\LoggerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

final class HomeController
{
    private $view;
    private $logger;
	private $user;

    public function __construct($view, LoggerInterface $logger, $user)
    {
        $this->view = $view;
        $this->logger = $logger;
        $this->user = $user;
    }
    public function dispatch(Request $request,Response $response, $args){
        if(isset($_SESSION['uniqid']) && isset($_SESSION['type'])){
            if ($_SESSION['type'] == 'org'){
                $this->view->render($response,'hello_org.twig');

            }else{
                $this->view->render($response,'hello_user.twig');

            }

        }else{
            $this->view->render($response,'hello.twig');

        }
    }
}
