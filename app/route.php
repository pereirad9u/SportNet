<?php
/*
	Routes
	controller needs to be registered in dependency.php
*/

$app->get('/', 'App\Controllers\HomeController:dispatch')->setName('homepage');

$app->get('/createEpreuve/{id}', 'App\Controllers\EpreuveController:creationEpreuve')->setName('createEpreuve')->add($middleware_org_co);

$app->post('/createEpreuve/{id}', 'App\Controllers\EpreuveController:saveEpreuve')->add($middleware_org_co);

$app->get('/signuporg', 'App\Controllers\UserController:signupOrg')->setName('signuporg');

$app->get('/createevent','App\Controllers\EventController:formEvent')->setName('formulaire')->add($middleware_org_co);

$app->post('/createevent','App\Controllers\EventController:saveEvent')->add($middleware_org_co);

$app->get('/anEventOrg/{id}','App\Controllers\EventController:anEventOrg')->setName('anEventOrg')->add($middleware_org_co);

$app->get('/anEvent/{id}','App\Controllers\EventController:anEvent')->setName('anEvent');

$app->post('/signuporg', 'App\Controllers\UserController:addMemberOrg');

$app->get('/loginorg', 'App\Controllers\UserController:loginPageOrg')->setName('loginorg');

$app->post('/loginorg', 'App\Controllers\UserController:loginOrg');

$app->get('/signupuser', 'App\Controllers\UserController:signupUser')->setName('signupuser');

$app->post('/signupuser', 'App\Controllers\UserController:addMemberUser');

$app->get('/loginuser', 'App\Controllers\UserController:loginPageUser')->setName('loginuser');

$app->post('/loginuser', 'App\Controllers\UserController:loginUser');

$app->get('/participants/{id}', 'App\Controllers\EpreuveController:participants')->setName('participants')->add($middleware_org_co);

$app->post('/postresults', 'App\Controllers\UserController:upload_resultat')->add($middleware_org_co);

$app->get('/logout', 'App\Controllers\UserController:logout')->setName('logout');

$app->get('/resultat/{id}', 'App\Controllers\EventController:affichageResultat');

$app->get('/profil', 'App\Controllers\UserController:profil')->setName('profil')->add($middleware_user_co);

$app->get('/profil/{id}', 'App\Controllers\UserController:profilUser');

$app->get('/manageEvents', 'App\Controllers\EventController:manage')->setName('manage')->add($middleware_org_co);

$app->get('/search', 'App\Controllers\HomeController:search')->setName('search');

$app->get('/addpanier/{id}','App\Controllers\UserController:addPanier')->setName('addpanier')->add($middleware_user_co);

$app->get('/addpanier/{idepreuve}/{idgroupe}','App\Controllers\UserController:addPanierGroup')->setName('addpanier')->add($middleware_user_co);

$app->get('/panier','App\Controllers\UserController:panier')->setName('panier')->add($middleware_user_co);

$app->get('/delElemPanier/{idelem}','App\Controllers\UserController:delelempanier')->add($middleware_user_co);

$app->get('/inscription/{id}','App\Controllers\UserController:inscription')->setName('inscription');

$app->get('/inscriptionall', 'App\Controllers\UserController:inscriptionall')->setName('inscriptionall')->add($middleware_user_co);

$app->get('/creategroup', 'App\Controllers\UserController:creategroup')->setName('creategroup')->add($middleware_user_co);


$app->post('/creategroup', 'App\Controllers\UserController:addgroup')->add($middleware_user_co);


$app->post('/ajax/openInscription','App\Controllers\AjaxController:openInscription')->add($middleware_org_co);
$app->post('/ajax/closeInscription','App\Controllers\AjaxController:closeInscription')->add($middleware_org_co);

$app->get('/deleteEpreuve/{id}','App\Controllers\EpreuveController:delete')->add($middleware_org_co);
