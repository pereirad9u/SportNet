<?php
/*
	Routes
	controller needs to be registered in dependency.php
*/

$app->get('/', 'App\Controllers\UserController:dispatch')->setName('homepage');

$app->get('/users', 'App\Controllers\UserController:dispatch')->setName('userpage');

$app->get('/signup', 'App\Controllers\UserController:signup')->setName('signup');

$app->post('/signup', 'App\Controllers\UserController:addMember');

$app->get('/login', 'App\Controllers\UserController:loginPage')->setName('login');

$app->post('/login', 'App\Controllers\UserController:login');

$app->get('/logout', 'App\Controllers\UserController:logout')->setName('logout');
