<?php

namespace Core;

class Router{
    private $routes = [];

    public function get($route, $callback){
        $this->addRoute('GET', $route, $callback);
    }

    public function post($route, $callback){
        $this->addRoute('POST', $route, $callback);
    }

    public function put($route, $callback){
        $this->addRoute('PUT', $route, $callback);
    }
    public function delete($route, $callback){
        $this->addRoute('DELETE', $route, $callback);
    }

    private function addRoute($method, $route, $callback){
        $route = preg_replace('/\{([a-zA-Z]+)\}/', ':$1', $route);
        $this->routes[$method][$route] = ['callback' => $callback, 'params' => []];

        preg_match_all('/:[a-zA-Z]+/', $route, $matches);
        foreach($matches[0] as $match){
            $this->routes[$method][$route]['params'][] = ltrim($match, ':');
        }
    }

    public function dispatch($method, $uri){
        // Manejo de la solicitud OPTIONS
        if ($method === 'OPTIONS') {
            header('Access-Control-Allow-Origin: *');
            header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
            header('Access-Control-Allow-Headers: Content-Type, Authorization');
            header('HTTP/1.1 204 No Content');
            exit; // Termina la ejecución para no procesar más
        }
    
        // Verificar si hay rutas definidas para el método
        if (!isset($this->routes[$method])) {
            $this->notFound();
            return;
        }
    
        foreach($this->routes[$method] as $route => $data){
            $pattern = '@^' . preg_replace('/\\\:[a-zA-Z]+/', '([^/]+)', preg_quote($route)) . '\/?$@D';
            if(preg_match($pattern, $uri, $matches)){
                $params = [];
                foreach($data['params'] as $param){
                    $params[$param] = array_shift($matches);
                }
    
                // Verificar si el callback es un array y llamar al controlador y método correspondientes
                if(is_array($data['callback']) && count($data['callback']) == 2){
                    $controller = $data['callback'][0];
                    $method = $data['callback'][1];
                    $this->callControllerMethod($controller, $method, $params);
                } else {
                    $data['callback']($params);
                }
    
                return;
            }
        }
        $this->notFound();
    }

    private function callControllerMethod($controller, $method, $params){
        $controllerFile = __DIR__ . '/../Controllers/' . $controller . '.php';
    
        if(file_exists($controllerFile)){
            require_once $controllerFile;
    
            $controllerClass = 'Controllers\\' . $controller;
            $controllerInstance = new $controllerClass();
    
            if(method_exists($controllerInstance, $method)){
                $controllerInstance->$method($params);
            } else {
                echo "Method <strong style='color: red'>$method</strong> not found in controller <strong style='color: red'>$controller</strong>";
            }
        } else {
            echo "Controller file <strong style='color: red'>$controller</strong> not found";
        }
    }

    
    public function notFound(){
        header("HTTP/1.0 404 Not Found");
        echo "Error 404 - Page not found";
    }
}
