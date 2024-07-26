<?php

$router->get('/', ['UsersController', 'home']);
$router->post('/login', ['UsersController', 'login']);
$router->post('/register', ['UsersController', 'register']);

//users
$router->get('/listUsers', ['UsersController', 'listUsers']);
$router->post('/createUser', ['UsersController', 'createUser']);
$router->post('/getUserData', ['UsersController', 'getUserData']);
$router->post('/updateUser', ['UsersController', 'updateUser']);
$router->post('/deleteUser', ['UsersController', 'deleteUser']);

// products
$router->get('/listProducts', ['ProductController', 'listProduct']);
$router->get('/listProducts/:id',  ['ProductController', 'listOneProduct']);
$router->post('/addProduct', ['ProductController', 'addProduct']);
$router->post('/updateProduct', ['ProductController', 'updateProduct']);
$router->post('/deleteProduct', ['ProductController', 'deleteProduct']);
$router->post('/apartarProducto', ['ApartadoController', 'apartar']);

// Users 
$router->get('/countData', ['UsersController', 'countData']);

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