<?php
/**
 * Created by PhpStorm.
 * User: debian
 * Date: 15/11/16
 * Time: 10:29
 */


namespace App\Controllers;

use App\Models\Epreuves;
use App\Models\UserEpreuve;
use App\Models\Events;
use App\Models\Results;
use App\Models\Users;
use App\Models\Organisers;
use App\Models\Groups;
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
        $event->id_organisateur = $_SESSION['uniqid'];

        $event->save();

        $url = $this->router->pathfor('createEpreuve',['id' =>$event->id]);
        return $response->withStatus(302)->withHeader('Location',$url);


    }

    public function anEventOrg(Request $request, Response $response,$args){
        $url = $_SERVER['HTTP_HOST'].substr($_SERVER['PATH_INFO'], 0, 8).substr($_SERVER['PATH_INFO'], 11);
        $event = Events::find($args['id']);
        $tabEpreuve = Epreuves::where('id_evenement','like',$event->id)->get();
        return $this->view->render($response,'anEventOrg.twig', array('url'=>$url, 'event'=>$event,'tabEpreuve'=>$tabEpreuve  ));
    }

    public function anEvent(Request $request, Response $response,$args){
        $event = Events::find($args['id']);
        $organiser = Organisers::find($event->id_organisateur);
        $tabEpreuve = Epreuves::where('id_evenement','like',$event->id)->get();
        foreach ($tabEpreuve as $epreuve) {
          if (UserEpreuve::where('id_epreuves','=',$epreuve->id)->where('id_users','=',$_SESSION['uniqid'])->count() > 0){
            $epreuve->participe = true;
          }else{
            $epreuve->participe = false;
          }
        }

        if (Groups::where('id_responsable','=',$_SESSION['uniqid'])->count()  > 0){
          $tabGroups = array();
          foreach (Groups::where('id_responsable','=',$_SESSION['uniqid'])->get() as $group) {
              array_push($tabGroups,$group);
          }
        }
        return $this->view->render($response,'anEvent.twig', array( 'event'=>$event,'tabEpreuve'=>$tabEpreuve, 'organiser'=>$organiser, 'tabGroups'=>$tabGroups  ));
    }

    private function modifDate($date) {
        $date_explode = explode(' ', $date);
        $mois_explode = explode(',', $date_explode[1]);
        switch ($mois_explode[0]) {
            case "January":
                $mois_explode[0] = '01';
                break;
            case "February":
                $mois_explode[0] = '02';
                break;
            case "March":
                $mois_explode[0] = '03';
                break;
            case "April":
                $mois_explode[0] = '04';
                break;
            case "May":
                $mois_explode[0] = '05';
                break;
            case "June":
                $mois_explode[0] = '06';
                break;
            case "July":
                $mois_explode[0] = '07';
                break;
            case "August":
                $mois_explode[0] = '08';
                break;
            case "September":
                $mois_explode[0] = '09';
                break;
            case "October":
                $mois_explode[0] = '10';
                break;
            case "November":
                $mois_explode[0] = '11';
                break;
            case "December":
                $mois_explode[0] = '12';
                break;
        }
        return "$date_explode[2]-$mois_explode[0]-$date_explode[0]";
    }

    private function renderDate($date){
        $d = explode("-",$date);

        return "$d[2]/$d[1]/$d[0]";

    }

    public function affichageResultat(Request $request, Response $response,$args) {
        $datas =[];
        $resultats = Results::where('id_epreuve', $args{'id'})->get();
        $datas[0] = ['nom', 'prenom', 'classement', 'temps'];
        foreach ($resultats as $r) {
            $d=[];
            $user = Users::find($r->id_utilisateur);
            array_push($d, $user->nom);
            array_push($d, $user->prenom);
            array_push($d, $r->classement);
            array_push($d, $r->temps);
            array_push($datas, $d);
        }
        return $this->view->render($response,'resultEvent.twig', array('datas' => $datas));
    }

    public function manage(Request $request, Response $response,$args){
        if(isset($_SESSION['uniqid']) && isset($_SESSION['type']) && $_SESSION['type'] == 'org'){
            $events = Events::where('id_organisateur',$_SESSION['uniqid'])->get();

            foreach ($events as $item){
                $item->date_debut = $this->renderDate($item->date_debut);
                $item->nb_epreuve = Epreuves::where('id_evenement',$item->id)->count();
                switch ($item->etat){
                    case 'nonvalide':
                        $item->etat = "Non validé";
                        break;
                    case 'valide':
                        $item->etat = "Non validé";
                        break;
                }
            }
            return $this->view->render($response,'manageEvents.twig', array('events' => $e));
        }else{
            return $this->response->withRedirect($this->view->pathFor('homepage'));
        }

    }

}
