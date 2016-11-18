<?php

namespace App\Controllers;

use App\Models\Events;
use App\Models\Users;
use App\Models\Epreuves;
use Psr\Log\LoggerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Sirius\Validation\Rule\Date;
use Sirius\Validation\Rule\DateTime;

final class HomeController
{
    private $view;
    private $logger;
    private $user;

    private function renderDate($date)
    {
        $d = explode("-", $date);
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
                $e = Events::where('id_organisateur', $_SESSION['uniqid'])->orderBy('date_debut', 'desc')->first();
                $e->date_debut = $this->renderDate($e->date_debut);
                $e->nb_epreuve = Epreuves::where('id_evenement', $e->id)->count();
                switch ($e->etat) {
                    case 'nonvalide':
                        $e->etat = "Non validé";
                        break;
                    case 'valide':
                        $e->etat = "Non validé";
                        break;
                }
                $this->view->render($response, 'hello_org.twig', ['e' => $e]);

            } else {
                $u = Users::find($_SESSION['uniqid']);
                $this->view->render($response, 'hello_user.twig');

            }

        } else {

            $this->view->render($response, 'hello.twig');

        }
    }

    public function search(Request $request, Response $response, $args)
    {
        if (isset($_GET['recherche']) && $_GET['recherche'] != "") {
            $recherche = $_GET['recherche'];

            $events = Events::where('nom', 'like', '%' . $recherche . '%')->where('etat','!=','nonvalide');
            if (isset($_GET['date']) && $_GET['date'] != "") {
                $events->where('date_debut','<=',$_GET['date'])->where('date_fin','>=',$_GET['date']);
            }
            if (isset($_GET['lieu']) && $_GET['lieu'] != "") {
                $events->where('lieu','like',$_GET['lieu']);

            }
            if (isset($_GET['discipline']) && $_GET['discipline'] != "") {
                $events->where('lieu','like',$_GET['discipline']);


            }
            $events = $events->get();
            foreach ($events as $event) {
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
            }
            return $this->view->render($response, 'search.twig', ['recherche' => $recherche, 'events' => $events,'get'=> $_GET]);

        }
        return $this->view->render($response, 'search.twig');

    }
}
