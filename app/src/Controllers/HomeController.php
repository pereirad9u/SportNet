<?php

namespace App\Controllers;

use App\Models\Events;
use App\Models\Users;
use App\Models\Epreuves;
use Psr\Log\LoggerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

final class HomeController
{
    private $view;
    private $logger;
    private $user;

    private function renderDate($date){
        $d = explode("-",$date);
        return "$d[2]/$d[1]/$d[0]";
    }

    public function __construct($view, LoggerInterface $logger, $user)
    {
        $this->view = $view;
        $this->logger = $logger;
        $this->user = $user;
    }

    public function dispatch(Request $request, Response $response, $args)
    {
        if (isset($_SESSION['uniqid']) && isset($_SESSION['type'])) {
            if ($_SESSION['type'] == 'org') {
                $event = Events::where('id_organisateur', $_SESSION['uniqid'])->orderBy('date_debut', 'desc')->first();
                $event->date_debut = $this->renderDate($event->date_debut);
                $event->nb_epreuve = Epreuves::where('id_evenement', $event->id)->count();
                switch ($event->etat) {
                    case 'nonvalide':
                        $event->etat = "Non validé";
                        break;
                    case 'valide':
                        $event->etat = "Non validé";
                        break;
                }
                $this->view->render($response, 'hello_org.twig',['e'=>$event]);

            } else {
                $user = Users::find($_SESSION['uniqid']);
                $this->view->render($response, 'hello_user.twig');

            }

        } else {

            $this->view->render($response, 'hello.twig');

        }
    }

    public function search(Request $request, Response $response, $args)
    {
        $this->view->render($response, 'search.twig');

    }
}
