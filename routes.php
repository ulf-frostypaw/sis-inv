<?php

$router->get('/home', ['UsersController', 'index']);
$router->post('/login', ['UsersController', 'login']);
$router->post('/register', ['UsersController', 'register']);

//users
$router->get('/listUsers', ['UsersController', 'listUsers']);

// products
$router->get('/listProducts', ['ProductController', 'listProduct']);
$router->get('/listProducts/:id',  ['ProductController', 'listOneProduct']);
$router->post('/addProduct', ['ProductController', 'addProduct']);
$router->put('/updateProduct', ['ProductController', 'updateProduct']);
$router->delete('/deleteProduct', ['ProductController', 'deleteProduct']);
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