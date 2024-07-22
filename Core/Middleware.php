<?php

namespace Core;
class Middleware{
    // load all middlewares here. 
    public static function load(){
        $middlewares = require_once __DIR__ . '/../Config/middlewares.php';
        foreach($middlewares as $middleware){
            if (!isset($middlewareInstance)) {
                $middlewareInstance = new $middleware();
            }
            $middlewareInstance->handle();
        }
    }
}