<?php
namespace Controllers;

use Core\Json;
use Core\Database;

class Controller{
    protected $database;
    protected  $json;
    
    public  function __construct()
    {
        $this->database = new Database();
        $this->json = new Json();
    }
}