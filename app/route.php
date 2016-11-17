<?php
/*
	Routes
	controller needs to be registered in dependency.php
*/

$app->get('/', 'App\Controllers\HomeController:dispatch')->setName('homepage');

$app->get('/users', 'App\Controllers\UserController:dispatch')->setName('userpage');

$app->get('/createEpreuve/{id}', 'App\Controllers\EpreuveController:creationEpreuve')->setName('createEpreuve');

$app->post('/createEpreuve/{id}', 'App\Controllers\EpreuveController:saveEpreuve');

$app->get('/signuporg', 'App\Controllers\UserController:signupOrg')->setName('signuporg');

$app->get('/createevent','App\Controllers\EventController:formEvent')->setName('formulaire');

$app->post('/createevent','App\Controllers\EventController:saveEvent');

$app->get('/anEventOrg/{id}','App\Controllers\EventController:anEventOrg')->setName('anEventOrg');

$app->get('/anEvent/{id}','App\Controllers\EventController:anEvent')->setName('anEvent');

$app->post('/signuporg', 'App\Controllers\UserController:addMemberOrg');

$app->get('/loginorg', 'App\Controllers\UserController:loginPageOrg')->setName('loginorg');

$app->post('/loginorg', 'App\Controllers\UserController:loginOrg');

$app->get('/signupuser', 'App\Controllers\UserController:signupUser')->setName('signupuser');

$app->post('/signupuser', 'App\Controllers\UserController:addMemberUser');

$app->get('/loginuser', 'App\Controllers\UserController:loginPageUser')->setName('loginuser');

$app->post('/loginuser', 'App\Controllers\UserController:loginUser');

$app->get('/participants/{id}', 'App\Controllers\EpreuveController:participants')->setName('participants');

$app->post('/postresults', 'App\Controllers\UserController:upload_resultat');

$app->get('/logout', 'App\Controllers\UserController:logout')->setName('logout');

$app->get('/resultat/{id}', 'App\Controllers\EventController:affichageResultat');


$app->get('/profil/{id}', 'App\Controllers\UserController:profil')->setName('profil');

$app->get('/manageEvents', 'App\Controllers\EventController:manage')->setName('manage');

$app->get('/search', 'App\Controllers\HomeController:search')->setName('search');

$app->get('/addpanier/{id}','App\Controllers\UserController:addPanier')->setName('addpanier');

$app->get('/panier','App\Controllers\UserController:panier')->setName('panier');

$app->get('/delElemPanier/{id}','App\Controllers\UserController:delelempanier');

$app->get('/inscription/{id}','App\Controllers\UserController:inscription')->setName('inscription');

$app->get('/inscriptionall', 'App\Controllers\UserController:inscriptionall')->setName('inscriptionall');
