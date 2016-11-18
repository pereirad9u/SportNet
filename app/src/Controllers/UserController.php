<?php

namespace App\Controllers;

use App\Models\Epreuves;
use App\Models\Events;
use App\Models\Organisers;
use App\Models\Results;
use App\Models\UserEpreuve;
use App\Models\Users;
use App\Models\Groups;
use App\Models\UserGroup;

use Illuminate\Database\Capsule\Manager;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;

use Psr\Log\LoggerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

final class UserController
{
    private $view;
    private $logger;
    private $user;

    public function __construct($c)
    {
      $this->view = $c->get('view');
      $this->logger = $c->get('logger');
      $this->model = $c->get('App\Repositories\UserRepository');
      $this->router = $c->get('router');
    }

    public function dispatch(Request $request, Response $response, $args)
    {
        $this->logger->info("Home page action dispatched");

		      $users = $this->model->show();

		return $this->view->render($response, 'users.twig', ["data" => $users]);
    }

    public function signupOrg(Request $request, Response $response, $args){
      return $this->view->render($response,'signuporg.twig', array('errors' => $errors));
    }

    public function signupUser(Request $request, Response $response, $args){
            return $this->view->render($response,'signupuser.twig', array('errors' => $errors));

    }

    public function addMemberOrg(Request $request, Response $response, $args) {
        if (isset($_POST['action']) && ($_POST['action'] == 'subInscription')) {
            if (isset($_POST['name']) && isset($_POST['firstname']) && isset($_POST['association']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['website']) && isset($_POST['tel']) )  {

                $nom = $_POST['name'];
                $prenom = $_POST['firstname'];
                $asso = $_POST['association'];
                $email = $_POST['email'];
                $pass = $_POST['password'];
                $website = $_POST['website'];
                $tel = $_POST['tel'];

                $errors = array ();

                if ($nom != filter_var ( $nom, FILTER_SANITIZE_STRING )) {
                    array_push ( $errors, "Nom invalide, merci de corriger" );
                }
                if ($prenom != filter_var ( $prenom, FILTER_SANITIZE_STRING )) {
                    array_push ( $errors, "Prenom invalide, merci de corriger" );
                }
                if ($asso != filter_var($asso, FILTER_SANITIZE_STRING)){
                    array_push ( $errors, "Nom asso invalide, merci de corriger" );
                }
                if ($email != filter_var ( $email, FILTER_VALIDATE_EMAIL )) {
                    array_push ( $errors, "Adresse email invalide, merci de corriger" );
                } else {
                    $emailVerif = \App\Models\Organisers::where ( 'email', $email )->get ();
                    if (sizeof ( $emailVerif ) != 0) {
                        array_push ( $errors, "Un compte a déjà été créé avec cette adresse email ou ce pseudo" );
                    }
                }
                if ($website != filter_var ( $website, FILTER_SANITIZE_STRING )) {
                    array_push ( $errors, "URL invalide, merci de corriger" );
                }
                if ($tel != filter_var ( $tel, FILTER_SANITIZE_STRING )) {
                    array_push ( $errors, "Numero de tel invalide, merci de corriger" );
                }
                if ($pass != filter_var ( $pass, FILTER_SANITIZE_STRING )) {
                    array_push ( $errors, "Mot de passe invalide, merci de corriger" );
                }


                if (sizeof ( $errors ) == 0) {
                    $nom = filter_var ( $nom, FILTER_SANITIZE_STRING );
                    $prenom = filter_var ( $prenom, FILTER_SANITIZE_STRING );
                    $email = filter_var ( $email, FILTER_SANITIZE_EMAIL );
                    $tel = filter_var($tel, FILTER_SANITIZE_STRING );
                    $website = filter_var($website, FILTER_SANITIZE_STRING );
                    $asso = filter_var($asso, FILTER_SANITIZE_STRING );
                    $pass = password_hash ( $pass, PASSWORD_DEFAULT, array (
                        'cost' => 12,
                    ) );
                    $organiser = new \App\Models\Organisers();
                    $organiser->id = uniqid();
                    $organiser->nom = $nom;
                    $organiser->prenom = $prenom;
                    $organiser->nom_association = $asso;
                    $organiser->email = $email;
                    $organiser->siteweb = $website;
                    $organiser->telephone = $tel;
                    $organiser->motdepasse = $pass;
                    $organiser->save ();
                    return $response->withRedirect($this->router->pathFor('homepage'));

                }
                else {
                    return $this->view->render($response,'signuporg.twig', array('errors' => $errors));

                }
            }else{
                return $response->withRedirect($this->router->pathFor('homepage'));

            }
        }else{
            return $response->withRedirect($this->router->pathFor('homepage'));

        }
    }

    public function addMemberUser(Request $request, Response $response, $args) {
        if (isset($_POST['action']) && ($_POST['action'] == 'subInscription')) {
            if (isset($_POST['name']) && isset($_POST['firstname']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['tel']) )  {

                $nom = $_POST['name'];
                $prenom = $_POST['firstname'];
                $email = $_POST['email'];
                $pass = $_POST['password'];
                $tel = $_POST['tel'];

                $errors = array ();

                if ($nom != filter_var ( $nom, FILTER_SANITIZE_STRING )) {
                    array_push ( $errors, "Nom invalide, merci de corriger" );
                }
                if ($prenom != filter_var ( $prenom, FILTER_SANITIZE_STRING )) {
                    array_push ( $errors, "Prenom invalide, merci de corriger" );
                }
                if ($email != filter_var ( $email, FILTER_VALIDATE_EMAIL )) {
                    array_push ( $errors, "Adresse email invalide, merci de corriger" );
                } else {
                    $emailVerif = \App\Models\Users::where ( 'email', $email )->get ();
                    if (sizeof ( $emailVerif ) != 0) {
                        array_push ( $errors, "Un compte a déjà été créé avec cette adresse email ou ce pseudo" );
                    }
                }
                if ($tel != filter_var ( $tel, FILTER_SANITIZE_STRING )) {
                    array_push ( $errors, "Numero de tel invalide, merci de corriger" );
                }
                if ($pass != filter_var ( $pass, FILTER_SANITIZE_STRING )) {
                    array_push ( $errors, "Mot de passe invalide, merci de corriger" );
                }


                if (sizeof ( $errors ) == 0) {
                    $nom = filter_var ( $nom, FILTER_SANITIZE_STRING );
                    $prenom = filter_var ( $prenom, FILTER_SANITIZE_STRING );
                    $email = filter_var ( $email, FILTER_SANITIZE_EMAIL );
                    $tel = filter_var($tel, FILTER_SANITIZE_STRING );
                    $pass = password_hash ( $pass, PASSWORD_DEFAULT, array (
                        'cost' => 12,
                    ) );
                    $m = new \App\Models\User();
                    $m->id = uniqid();
                    $m->nom = $nom;
                    $m->prenom = $prenom;
                    $m->email = $email;
                    $m->telephone = $tel;
                    $m->motdepasse = $pass;
                    $m->save ();

                    $_SESSION['uniqid']=$m->id;
                    $user = new \App\Models\Users();
                    $user->id = uniqid();
                    $user->nom = $nom;
                    $user->prenom = $prenom;
                    $user->email = $email;
                    $user->telephone = $tel;
                    $user->motdepasse = $pass;
                    $user->save ();

                    $_SESSION['uniqid']=$user->id;
                    $_SESSION['type']='user';

                    if(isset($_SESSION['route'])){
                        $derniere_route = $_SESSION['route'];
                        unset($_SESSION['route']);
                        return $response->withStatus(302)->withHeader('Location',$derniere_route);
                    }else{
                        return $response->withRedirect($this->router->pathFor('homepage'));
                    }

                }
                else {
                    return $this->view->render($response,'signupuser.twig', array('errors' => $errors));

                }
            }else{
                return $response->withRedirect($this->router->pathFor('homepage'));

            }
        }else{
            return $response->withRedirect($this->router->pathFor('homepage'));

        }
    }

    public function loginPageOrg(Request $request, Response $response, $args) {
        return $this->view->render($response, 'loginorg.twig');
    }

    public function loginPageUser(Request $request, Response $response, $args) {
        return $this->view->render($response, 'loginuser.twig');
    }

    public function loginOrg(Request $request, Response $response, $args) {
        if(isset($_POST['action']) && $_POST['action'] == 'loginorg') {
            if(isset($_POST["email"]) && isset($_POST["password"])) {
                $email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
                $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
                $organiser = Organisers::where("email", "=", $email)->get()->first();
                if(isset($organiser->id)) {
                    if (password_verify($password, $organiser->motdepasse)) {
                        $_SESSION["uniqid"] = $organiser->id;
                        $_SESSION["type"] = 'org';
                        return $response->withRedirect($this->router->pathFor('homepage'));
                    }
                    else {
                        $this->view->render($response, 'loginorg.twig', array('errors' => "error"));
                    }
                }
                else {
                    $this->view->render($response, 'loginorg.twig', array('errors' => "error"));
                }
            }
            else {
                $this->view->render($response, 'loginorg.twig', array('errors' => "error"));
            }
        }
        else {
            $this->view->render($response, 'loginorg.twig', array('errors' => "error"));
        }
    }

    public function loginUser(Request $request, Response $response, $args) {
        if(isset($_POST['action']) && $_POST['action'] == 'loginuser') {
            if(isset($_POST["email"]) && isset($_POST["password"])) {
                $email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
                $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
                $user = Users::where("email", $email)->get()->first();
                if(isset($user->id)) {
                    if (password_verify($password, $user->motdepasse)) {
                        $_SESSION["uniqid"] = $user->id;
                        $_SESSION["type"] = 'user';
                        if(isset($_SESSION['route'])){
                            $derniere_route = $_SESSION['route'];
                            unset($_SESSION['route']);
                            return $response->withStatus(302)->withHeader('Location',$derniere_route);
                        }else{
                            return $response->withRedirect($this->router->pathFor('homepage'));
                        }

                    }
                    else {
                        $this->view->render($response, 'loginuser.twig', array('errors' => "error"));
                    }
                }
                else {
                    $this->view->render($response, 'loginuser.twig', array('errors' => "error"));
                }
            }
            else {
                $this->view->render($response, 'loginuser.twig', array('errors' => "error"));
            }
        }
        else {
            $this->view->render($response, 'loginuser.twig', array('errors' => "error"));
        }
    }

    public function logout(Request $request, Response $response, $args){
        unset($_SESSION['uniqid']);
        return $response->withRedirect($this->router->pathFor('homepage'));
    }


    public function profil(Request $request, Response $response, $args)
    {

        if ($_SESSION['type'] == 'user') {
            $u = Users::find($_SESSION['uniqid']);
            $org = false;
            $e = Manager::select("select *, count(epreuves.id) as nb_epreuve
                                  from events join epreuves join users_epreuves join users
                                  where users.id=users_epreuves.id_users
                                  and users_epreuves.id_epreuves=epreuves.id
                                  and epreuves.id_evenement=events.id
                                  and users.id='".$_SESSION['uniqid']."'
                                  order by events.date_debut desc");
            $interessant = Manager::select("select *, count(epreuves.id) as nb_epreuve
                                            from events join epreuves
                                            where events.id = epreuves.id_evenement
                                            and events.etat = 'ouvertes'
                                            and epreuves.discipline = (select discipline
                                                                       from epreuves join users_epreuves
                                                                       where epreuves.id = users_epreuves.id_epreuves
                                                                       and users_epreuves.id_users = '". $_SESSION['uniqid'] ."'
                                                                       GROUP by discipline
                                                                       having count(discipline) >= (select COUNT(discipline) from epreuves join users_epreuves
                                                                                  where epreuves.id = users_epreuves.id_epreuves
                                                                                  and users_epreuves.id_users = '". $_SESSION['uniqid'] ."')
                                                                      )
                                            ");
            $r = Results::where('id_utilisateur', $_SESSION['uniqid'])
                ->join('epreuves', 'results.id_epreuve','=','epreuves.id')
                ->join('events', 'events.id', '=', 'epreuves.id_evenement')
                ->orderBy('events.date_fin')
                ->get(array('*', 'events.nom as nomE', 'epreuves.nom as nom'));
            foreach ($r as $res) {
                $res->date = $this->renderDate($res->date);
            }
        } else {
            $u = Organisers::find($_SESSION['uniqid']);
            $e = Manager::select("select *, count(epreuves.id) as nb_epreuve
                                  from events join epreuves
                                  where epreuves.id_evenement=events.id
                                  and events.id_organisateur='".$_SESSION['uniqid']."'
                                  order by events.date_debut desc");
            $org = true;
        }
        foreach ($e as $event) {
            $event->date_debut = $this->renderDate($event->date_debut);
        }
        $this->view->render($response, 'profil.twig', array('interessant' => $interessant, 'user' => $u, 'isOrg' => $org, 'events' => $e, 'results' => $r));
    }

    public function profilUser(Request $request, Response $response, $args)
    {
        if($_SESSION['uniqid'] == $args['id']) {
            return $response->withRedirect($this->router->pathFor('profil'));
        }
        $u = Users::find($args['id']);
        if ($u != null) {
            $org = false;
            $e = Manager::select("select *, count(epreuves.id) as nb_epreuve
                                  from events join epreuves join users_epreuves join users
                                  where users.id=users_epreuves.id_users
                                  and users_epreuves.id_epreuves=epreuves.id
                                  and epreuves.id_evenement=events.id
                                  and users.id='".$args['id']."'
                                  order by events.date_debut desc");
            $r = Results::where('id_utilisateur', $args['id'])
                ->join('epreuves', 'results.id_epreuve','=','epreuves.id')
                ->join('events', 'events.id', '=', 'epreuves.id_evenement')
                ->orderBy('events.date_fin')
                ->get(array('*', 'events.nom as nomE', 'epreuves.nom as nom'));
            foreach ($r as $res) {
                $res->date = $this->renderDate($res->date);
            }
        } else {
            $u = Organisers::find($args['id']);
            $e = Manager::select("select *, count(epreuves.id) as nb_epreuve
                                  from events join epreuves
                                  where epreuves.id_evenement=events.id
                                  and events.id_organisateur='".$args['id']."'
                                  order by events.date_debut desc");

            $org = true;
        }
        foreach ($e as $event) {
            $event->date_debut = $this->renderDate($event->date_debut);
        }
        $this->view->render($response, 'profilUser.twig', array('user' => $u, 'isOrg' => $org, 'events' => $e, 'results' => $r));
    }


    private function renderDate($date){
        $d = explode("-",$date);
        return "$d[2]/$d[1]/$d[0]";
    }

    public function upload_resultat(Request $request, Response $response, $args){
      //die(var_dump($_FILES['res']));
      if (isset($_FILES['res']) && $_POST['res_id']){
        for ($i=0; $i<count($_FILES['res']['tmp_name']); $i++){
          $csv = new \SplFileObject($_FILES['res']['tmp_name'][$i], 'r');
          $csv->setFlags(\SplFileObject::READ_CSV);
          $csv->setCsvControl(';', '"', '"');
          foreach($csv as $ligne)
          {
            if ($ligne[0] != null && $ligne[1] != null && $ligne[2] != null){
              $num_doss = $ligne[0];
              $classement = intval($ligne[1]);
              $temps = $ligne[2];
              $id_user = \App\Models\UserEpreuve::where('id_epreuves', '=', $_POST['res_id'][$i])->where('num_dossard', '=', $num_doss)->first()->id_users;
              if (\App\Models\Results::where('id_utilisateur', '=', $id_user)->where('id_epreuve','=',$_POST['res_id'][$i])->count() == 0){
                $res = new \App\Models\Results();
                $res->id=uniqid();
                $res->classement = $classement;
                $res->temps = $temps;
                $res->id_utilisateur = $id_user;
                $res->id_epreuve = $_POST['res_id'][$i];
                $res->save();
              }else{
                $res = \App\Models\Results::where('id_utilisateur', '=', $id_user)->where('id_epreuve','=',$_POST['res_id'][$i])->update(['classement' => $classement, 'temps' => $temps]);
              }
            }
          }
        }
        return $response->withRedirect($this->router->pathFor('homepage'));
      }
    }

    public function inscription(Request $request, Response $response, $args){
        if(isset($_SESSION['uniqid']) && isset($_SESSION['type']) && $_SESSION['type']=='user'){
            if(sizeof(UserEpreuve::where('id_users',$_SESSION['uniqid'])->where('id_epreuves',$args['id'])->get()) >0){
                return $this->view->render($response,'inscription.twig',['erreur'=>'Vous êtes déjà inscrit à cette épreuve']);

            }else{
                $inscription = new UserEpreuve();
                $inscription->id_users = $_SESSION['uniqid'];
                $inscription->id_epreuves = $args['id'];
                $inscription->save();
                $epreuve = Epreuves::find($args['id']);
                $epreuve->nb_participants++;
                $epreuve->save();
                $event = Events::find($epreuve->id_evenement);
                $tabEpreuves = Epreuves::where('id_evenement',$event->id)->get();
                $ajout=true;
                foreach($tabEpreuves as $t){
                    if(UserEpreuve::where('id_users',$_SESSION['uniqid'])->where('id_epreuves',$t->id)->count()>0){
                        $ajout=false;
                        break;
                    }
                }
                if ($ajout){
                    $event->nb_participants++;
                    $event->save();
                }
                return $this->view->render($response,'inscription.twig');
            }
        }else{

            $_SESSION['route']=$request->getUri()->getPath();
            return $response->withRedirect($this->router->pathFor('loginuser'));
        }

    }

    public function addPanier(Request $request, Response $response, $args){

      if (!isset($_SESSION['panier'])){
        $_SESSION['panier'] = array();
      }
      $e = Epreuves::find($args['id']);
      $e->id_elem = uniqid();
      array_push($_SESSION['panier'],$e);
      $event = Events::find($e->id_evenement);

      $organiser = Organisers::find($event->id_organisateur);
      $tabEpreuve = Epreuves::where('id_evenement','like',$event->id)->get();
      return $this->view->render($response,'anEvent.twig',array( 'event'=>$event,'tabEpreuve'=>$tabEpreuve, 'organiser'=>$organiser  ));
    }

    public function addPanierGroup(Request $request, Response $response, $args){
      if (!isset($_SESSION['panier'])){
        $_SESSION['panier'] = array();
      }
      $epreuve = Epreuves::find($args['idepreuve']);
      $epreuve_responsable = new Epreuves();
      $epreuve_responsable = $epreuve;
      $epreuve_responsable->id_participant = $_SESSION['uniqid'];
      $epreuve_responsable->nom_responsable = Users::find($_SESSION['uniqid'])->nom;
      $epreuve_responsable->prenom_responsable = Users::find($_SESSION['uniqid'])->prenom;
      $epreuve_responsable->id_elem = uniqid();
      array_push($_SESSION['panier'],$epreuve);
      foreach (UserGroup::where('id_group','=',$args['idgroupe'])->get() as $membres) {
        $new_epreuve = new Epreuves();
        $new_epreuve->id = $epreuve->id;
        $new_epreuve->nom = $epreuve->nom;
        $new_epreuve->description = $epreuve->description;
        $new_epreuve->date = $epreuve->date;
        $new_epreuve->inscription = $epreuve->inscription;
        $new_epreuve->id_evenement = $epreuve->id_evenement;
        $new_epreuve->nb_participants = $epreuve->nb_participants;
        $new_epreuve->nb_participants_max = $epreuve->nb_participants_max;
        $new_epreuve->prix = $epreuve->prix;
        $new_epreuve->discipline = $epreuve->discipline;
        $new_epreuve->image = $epreuve->image;
        $new_epreuve->id_participant = $membres->id_utilisateur;
        $new_epreuve->nom_participant = Users::find($membres->id_utilisateur)->nom;
        $new_epreuve->prenom_participant = Users::find($membres->id_utilisateur)->prenom;
        $new_epreuve->id_elem = uniqid();
        array_push($_SESSION['panier'],$new_epreuve);
      }
      //$e->prix = $e->prix * UserGroup::where('id_group','=',$args['idgroup'])->count();
      //array_push($_SESSION['panier'],$e);
      $event = Events::find($epreuve->id_evenement);
      $organiser = Organisers::find($event->id_organisateur);
      $tabEpreuve = Epreuves::where('id_evenement','like',$event->id)->get();

      //a remplacer par un redirect !!!
      if (Groups::where('id_responsable','=',$_SESSION['uniqid'])->count()  > 0){
        $tabGroups = array();
        foreach (Groups::where('id_responsable','=',$_SESSION['uniqid'])->get() as $group) {
            array_push($tabGroups,$group);
        }
      }
      return $this->view->render($response,'anEvent.twig',array( 'event'=>$event,'tabEpreuve'=>$tabEpreuve, 'organiser'=>$organiser, 'tabGroups'=>$tabGroups  ));
      //return $response->withRedirect($this->router->pathFor('anEvent'));
    }

    public function panier(Request $request, Response $response, $args){
      $prix_total = 0;
      foreach ($_SESSION['panier'] as $elem) {
        $prix_total = $prix_total + $elem->prix;
      }
      return $this->view->render($response,'panier.twig',array( 'elements'=>$_SESSION['panier'] , 'prix_total'=>$prix_total));
    }

    public function delelempanier(Request $request, Response $response, $args){
      
      $tab = array();
      foreach ($_SESSION['panier'] as $value) {
        if($value->id_elem != $args['idelem']){
          array_push($tab, $value);
        }
      }
      unset($_SESSION['panier']);
      $_SESSION['panier']= array();
      $prix_total = 0;
      foreach ($tab as $new_value) {
        array_push($_SESSION['panier'], $new_value);
        $prix_total = $prix_total + $new_value->prix;
      }
      return $this->view->render($response,'panier.twig',array( 'elements'=>$_SESSION['panier'] , 'prix_total'=>$prix_total));
    }

    public function inscriptionall(Request $request, Response $response, $args){
      foreach($_SESSION['panier'] as $epreuve){

        $e = new UserEpreuve();
        $e->id_users = $epreuve->id_participant;
        $e->id_epreuves = $epreuve->id;
        $e->num_dossard = UserEpreuve::where('id_epreuves','=',$epreuve->id)->max('num_dossard') + 1;
        $e->save();

      }
      $_SESSION['panier'] = array();
      return $response->withRedirect($this->router->pathFor('homepage'));
    }

    public function creategroup(Request $request, Response $response, $args){
      return $this->view->render($response, 'creategroup.twig');
    }

    public function addgroup(Request $request, Response $response, $args){
      $nom_group = $_POST['name_group'];
      $new_group = new Groups();
      $new_group->id = uniqid();
      $new_group->nom = $nom_group;
      $new_group->id_responsable = $_SESSION['uniqid'];

      $tab_adherent = array();
      foreach ($_POST['email_adherents'] as $adherent){
        if (Users::where('email','=',$adherent)->count() > 0){
          $new_adherent = new UserGroup();
          $new_adherent->id_utilisateur = Users::where('email','=',$adherent)->first()->id;
          $new_adherent->id_group = $new_group->id;
          array_push($tab_adherent, $new_adherent);
        }
      }
      $new_group->save();
      foreach ($tab_adherent as $adherent) {
        $adherent->save();
      }
      return $response->withRedirect($this->router->pathFor('homepage'));
    }
}
