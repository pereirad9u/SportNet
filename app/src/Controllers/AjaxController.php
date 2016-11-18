<?php
/**
 * Created by PhpStorm.
 * User: debian
 * Date: 18/11/16
 * Time: 09:04
 */

namespace App\Controllers;


use App\Models\Epreuves;
use App\Models\Events;
use App\Models\UserEpreuve;
use App\Models\Users;
use Psr\Log\LoggerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;


class AjaxController
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


    public function openInscription(Request $request, Response $response, $args){


        $epreuve= \App\Models\Epreuves::find($_POST['id']);
        $epreuve->inscription = 1;
        $epreuve->save();


        echo json_encode('');
    }

    public function closeInscription(Request $request, Response $response, $args){


        $epreuve= \App\Models\Epreuves::find($_POST['id']);
        $epreuve->inscription = 0;
        $epreuve->save();


        echo json_encode('');
    }

}