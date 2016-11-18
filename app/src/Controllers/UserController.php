<?php

namespace App\Controllers;

use App\Models\Epreuves;
use App\Models\Events;
use App\Models\Organisers;
use App\Models\User;

use App\Models\UserEpreuve;
use Psr\Log\LoggerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

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
                    $emailVerif = \App\Models\User::where ( 'email', $email )->get ();
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
                    $m = new \App\Models\Organisers();
                    $m->id = uniqid();
                    $m->nom = $nom;
                    $m->prenom = $prenom;
                    $m->nom_association = $asso;
                    $m->email = $email;
                    $m->siteweb = $website;
                    $m->telephone = $tel;
                    $m->motdepasse = $pass;
                    $m->save ();
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
                    $emailVerif = \App\Models\User::where ( 'email', $email )->get ();
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
                    $_SESSION['type']='user';

                    if(isset($_SESSION['route'])){
                        $r = $_SESSION['route'];
                        unset($_SESSION['route']);
                        return $response->withStatus(302)->withHeader('Location',$r);
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
                $m = Organisers::where("email", "=", $email)->get()->first();
                if(isset($m->id)) {
                    if (password_verify($password, $m->motdepasse)) {
                        $_SESSION["uniqid"] = $m->id;
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
                $m = User::where("email", $email)->get()->first();
                if(isset($m->id)) {
                    if (password_verify($password, $m->motdepasse)) {
                        $_SESSION["uniqid"] = $m->id;
                        $_SESSION["type"] = 'user';
                        if(isset($_SESSION['route'])){
                            $r = $_SESSION['route'];
                            unset($_SESSION['route']);
                            return $response->withStatus(302)->withHeader('Location',$r);
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
}
