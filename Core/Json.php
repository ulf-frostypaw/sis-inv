<?php
namespace Core;

class Json
{
    
    public static function encode($data)
    {
        header('Content-Type: application/json');
        echo json_encode($data);
    }
    public static function decode($data)
    {
        return json_decode($data);
    }
}