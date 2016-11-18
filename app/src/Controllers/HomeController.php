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

                $last_events = Events::where('date_fin', '<', date('Y-m-d'))->orderBy('date_fin')->get();
                $i = 0;
                $tabLastEvents = array();
                foreach ($last_events as $last_ev) {
                    $i++;
                    array_push($tabLastEvents, $last_ev);
                    if ($i == 3)
                        break;

                }
                $this->view->render($response, 'hello_org.twig', ['e' => $event, 'last_events' => $tabLastEvents]);
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
        if (isset($_GET['recherche']) || isset($_GET['date']) || isset($_GET['lieu'])){
            $events =Events::where('etat', '!=', 'nonvalide');
            if (isset($_GET['recherche'])) {
                $recherche = $_GET['recherche'];
                $events->where('nom', 'like', '%'.$recherche.'%');
            }
            if (isset($_GET['date']) && $_GET['date'] != "") {
                $events->where('date_debut', '<=', $_GET['date'])->where('date_fin', '>=', $_GET['date']);
            }
            if (isset($_GET['lieu']) && $_GET['lieu'] != "") {
                $events->where('lieu', 'like', $_GET['lieu']);
            }
        }else{
            $events =Events::where('etat', '!=', 'nonvalide');
        }
        $events = $events->get();
        if (isset($_GET['discipline']) && $_GET['discipline'] != "") {
            $epreuves = Epreuves::where('discipline',$_GET['discipline'])->get();
            $temp_events = array();
            foreach ($epreuves as $epreuve){
                foreach ($events as $event){

                    echo '<pre>';
                    var_dump($epreuve->id);
                    echo '</pre>';

                    echo '<pre>';
                    var_dump($event->id);
                    echo '</pre>';
                    if ($event->id == $epreuve->id_evenement){
                        array_push($temp_events,$event);
                    }
                }
            }

            $events = array_unique($temp_events);
        }
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
        return $this->view->render($response, 'search.twig', ['events' => $events, 'get' => $_GET]);


    }
}
