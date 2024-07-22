<?php

namespace Controllers;

/* use Core\Json;
use Core\Database; */

class UsersController extends Controller
{
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
        //var_dump($data);

        $query = $this->database->read('SELECT * FROM usuario WHERE correo_usuario = ? AND contrasena = ?', [$email, $password]); // fetch all posts
        if (count($query) > 0) {
            echo $this->json->encode(['usuarios' => array($query)]);
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

        try {
            $query = $this->database->create('INSERT INTO usuario (id_tipo_usuario, nombre_completo, correo_usuario, contrasena) VALUES (?, ?, ?, ?)', [1, $name, $email, $password]); // fetch all posts
            echo $this->json->encode(['message' => 'Usuario registrado correctamente.']);
        } catch (\PDOException $e) {
            echo $this->json->encode(['message' => 'Error al registrar usuario.', 'error' => $e->getMessage()]);
        }
    }
}
