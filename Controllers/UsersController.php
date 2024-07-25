<?php

namespace Controllers;

/* use Core\Json;
use Core\Database; */

class UsersController extends Controller
{
    public function index()
    {
        echo 'Hello from UsersController';
    }
    public function listUsers()
    {
        $query = $this->database->read('SELECT * FROM usuario', ''); // fetch all posts
        if (count($query) > 0) {
            echo $this->json->encode(['usuarios' => array($query)]);
        } else {
            echo $this->json->encode(['message' => 'No hay usuarios registrados.']);
        }
    }
    public function login()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $email = $data['email'];
        $password = $data['password'];

        if (empty($email) || empty($password)) {
            echo $this->json->encode(['status' => 400, 'message' => 'Todos los campos son requeridos.']);
            return;
        }elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo $this->json->encode(['status' => 400, 'message' => 'Correo electrónico inválido.']);
            return;
        }elseif (strlen($password) < 6) {
            echo $this->json->encode(['status' => 400, 'message' => 'La contraseña debe tener al menos 6 caracteres.']);
            return;
        }elseif (count($this->database->read('SELECT * FROM usuario WHERE correo_usuario = ?', [$email])) == 0) {
            echo $this->json->encode(['status' => 400, 'message' => 'No se encontró ningún usuario con este correo electrónico.']);
            return;
        }

        $query = $this->database->read('SELECT id_tipo_usuario, nombre_completo, correo_usuario FROM usuario WHERE correo_usuario = ? AND contrasena = ?', [$email, $password]); // fetch all posts (id_tipo_usuario, nombre_completo, correo_usuario)
        if (count($query) > 0) {
            echo $this->json->encode(['status' => 200, 'data' => $query]);
        } else {
            echo $this->json->encode(['message' => 'Credenciales incorrectas. Inténtelo de nuevo.']);
        }
    }

    public function register()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $email = $data['email'];
        $password = $data['password'];
        $name = $data['name'];

        if (empty($email) || empty($password) || empty($name)) {
            echo $this->json->encode(['status' => 400, 'message' => 'Todos los campos son requeridos.']);
            return;
        }elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo $this->json->encode(['status' => 400, 'message' => 'Correo electrónico inválido.']);
            return;
        }elseif (strlen($password) < 6) {
            echo $this->json->encode(['status' => 400, 'message' => 'La contraseña debe tener al menos 6 caracteres.']);
            return;
        }elseif (strlen($name) < 3) {
            echo $this->json->encode(['status' => 400, 'message' => 'El nombre debe tener al menos 3 caracteres.']);
            return;
        }elseif (count($this->database->read('SELECT * FROM usuario WHERE correo_usuario = ?', [$email])) > 0) {
            echo $this->json->encode(['status' => 400, 'message' => 'Alguien más ya está usando este correo electrónico. Intente con otro.']);
            return;
        }


        try {
            $query = $this->database->create('INSERT INTO usuario (id_tipo_usuario, nombre_completo, correo_usuario, contrasena) VALUES (?, ?, ?, ?)', [3, $name, $email, $password]); // fetch all posts
            $data = $this->database->read('SELECT id_tipo_usuario, nombre_completo, correo_usuario FROM usuario WHERE correo_usuario = ? AND contrasena = ?', [$email, $password]); // fetch all posts (id_tipo_usuario, nombre_completo, correo_usuario)
            echo $this->json->encode(['status' => 200, 'message' => 'Usuario registrado correctamente.', 'data' => $data]);
        } catch (\PDOException $e) {
            echo $this->json->encode(['status' => 400, 'message' => 'Sucedió un error al registrar usuario.']);
        }
    }
}
