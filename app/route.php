<?php
/*
	Routes
	controller needs to be registered in dependency.php
*/

$app->get('/', 'App\Controllers\HomeController:dispatch')->setName('homepage');

$app->get('/users', 'App\Controllers\UserController:dispatch')->setName('userpage');

$app->get('/createevent','App\Controllers\EventController:formEvent')->setName('formulaire');
$app->post('/createevent','App\Controllers\EventController:saveEvent');

$app->get('/signup', 'App\Controllers\UserController:signup')->setName('signup');

$app->post('/signup', 'App\Controllers\UserController:addMember');

$app->get('/login', 'App\Controllers\UserController:loginPage')->setName('login');

$app->post('/login', 'App\Controllers\UserController:login');

$app->get('/logout', 'App\Controllers\UserController:logout')->setName('logout');

