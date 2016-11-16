<?php
/**
 * Created by PhpStorm.
 * User: debian
 * Date: 15/11/16
 * Time: 10:29
 */


namespace App\Controllers;

use App\Models\Epreuves;
use App\Models\Events;
use App\Models\Organisers;
use Prophecy\Argument;
use Psr\Log\LoggerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

final class EventController
{
    private $view;
    private $logger;
    private $router;

    public function __construct($c)
    {
        $this->view= $c->get('view');
        $this->logger= $c->get('logger');
        $this->router = $c->get('router');
    }

    public function formEvent(Request $request, Response $response,$args){

        return $this->view->render($response,'formEvent.twig', array(   ));

    }


    public function saveEvent(Request $request, Response $response,$args){

        $nom = filter_var ( $_POST['name'], FILTER_SANITIZE_STRING );
        $dateDebut =  $this->modifDate($_POST['dateDebut']);
        $dateFin =  $this->modifDate($_POST['dateFin']);
        $lieu = filter_var ( $_POST['lieu'], FILTER_SANITIZE_STRING );
        $description = filter_var ( $_POST['description'], FILTER_SANITIZE_STRING );

        $event = new Events();
        $event->id = uniqid();
        $event->nom = $nom;
        $event->date_debut = $dateDebut;
        $event->date_fin = $dateFin;
        $event->lieu = $lieu;
        $event->description = $description;
        $event->etat = "nonvalide";

        $event->save();

        $url = $this->router->pathfor('createEpreuve',['id' =>$event->id]);
        return $response->withStatus(302)->withHeader('Location',$url);


    }

    public function anEventOrg(Request $request, Response $response,$args){
        $event = Events::find($args['id']);
        $tabEpreuve = Epreuves::where('id_evenement','like',$event->id)->get();
        return $this->view->render($response,'anEventOrg.twig', array( 'event'=>$event,'tabEpreuve'=>$tabEpreuve  ));
    }

    public function anEvent(Request $request, Response $response,$args){
        $event = Events::find($args['id']);
        $organiser = Organisers::find($event->id_organisateur);
        $tabEpreuve = Epreuves::where('id_evenement','like',$event->id);
        return $this->view->render($response,'anEventOrg.twig', array( 'event'=>$event,'tabEpreuve'=>$tabEpreuve, 'organiser'=>$organiser  ));
    }

    private function modifDate($date) {
        $jm = explode(' ', $date);
        $m = explode(',', $jm[1]);
        switch ($m[0]) {
            case "January":
                $m[0] = '01';
                break;
            case "February":
                $m[0] = '02';
                break;
            case "March":
                $m[0] = '03';
                break;
            case "April":
                $m[0] = '04';
                break;
            case "May":
                $m[0] = '05';
                break;
            case "June":
                $m[0] = '06';
                break;
            case "July":
                $m[0] = '07';
                break;
            case "August":
                $m[0] = '08';
                break;
            case "September":
                $m[0] = '09';
                break;
            case "October":
                $m[0] = '10';
                break;
            case "November":
                $m[0] = '11';
                break;
            case "December":
                $m[0] = '12';
                break;
        }
        return "$jm[2]-$m[0]-$jm[0]";
    }


}