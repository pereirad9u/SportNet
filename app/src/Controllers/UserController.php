<?php

namespace App\Controllers;

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

    public function signup(Request $request, Response $response, $args){
      return $this->view->render($response,'signup.twig', array('errors' => $errors));
    }

    public function addMember(Request $request, Response $response, $args) {
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
                if ($adress != filter_var ( $adress, FILTER_SANITIZE_STRING )) {
                    array_push ( $errors, "Adresse invalide, merci de corriger" );
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
                    return $this->view->render($response,'signup.twig', array('errors' => $errors));

                }
            }else{
                return $response->withRedirect($this->router->pathFor('homepage'));

            }
        }else{
            return $response->withRedirect($this->router->pathFor('homepage'));

        }
    }

    public function loginPage(Request $request, Response $response, $args) {
        return $this->view->render($response, 'login.twig');
    }

    public function login(Request $request, Response $response, $args) {
        if(isset($_POST['action']) && $_POST['action'] == 'login') {
            if(isset($_POST["email"]) && isset($_POST["password"])) {
                $email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
                $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
                $m = Organisers::where("email", $email)->get()->first();
                if(isset($m->uniqid)) {
                    if (password_verify($password, $m->password)) {
                        $_SESSION["uniqid"] = $m->uniqid;
                        return $response->withRedirect($this->router->pathFor('homepage'));
                    }
                    else {
                        $this->view->render($response, 'login.twig', array('errors' => "error"));
                    }
                }
                else {
                    $this->view->render($response, 'login.twig', array('errors' => "error"));
                }
            }
            else {
                $this->view->render($response, 'login.twig', array('errors' => "error"));
            }
        }
        else {
            $this->view->render($response, 'login.twig', array('errors' => "error"));
        }
    }

    public function logout(Request $request, Response $response, $args){
        unset($_SESSION['uniqid']);
        return $response->withRedirect($this->router->pathFor('homepage'));
    }
}
