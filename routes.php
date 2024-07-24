<?php

$router->get('/home', ['UsersController', 'index']);
$router->post('/login', ['UsersController', 'login']);
$router->post('/register', ['UsersController', 'register']);

$router->get('/listProducts', ['ProductController', 'listProduct']);
/* $router->get('/posts/:id', function($params){
    $slug = $params['id'];
    $slugParts = explode('/', $slug);
    $slug = $slugParts[2];
    HomeController::post($slug);
}); */


// TODO: Arreglar parametros para lectura en array
$router->get('/users/:username', function($params){
    $username = $params['username'];
    $usernameParts = explode('/', $username);
    $user = $usernameParts[2];
    if(!empty($user)){
        echo $user;
    }
    
});


// TODO: ROUTER GROUPS