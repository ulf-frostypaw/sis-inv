<?php

// open CORS


namespace Core\Middleware;

class CorsMiddleware{
    public static function handle(){
        header("Access-Control-Allow-Origin: "  . APP_PUBLIC_URL);
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers");
        header("X-API-KEY: " . API_KEY);
    }
}