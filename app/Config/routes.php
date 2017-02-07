<?php

Router::get('/' , ['action' => "HomeController@index" , "name" => 'page.home']);
Router::get('/login' , ['action' => "AuthController@showLogin" , "name" => 'auth.login']);
Router::get('/register' , ['action' => "AuthController@showRegister" , "name" => "auth.register"]);


