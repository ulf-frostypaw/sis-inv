<?php

namespace Controllers;

/* use Core\Json;
use Core\Database; */

class UsersController extends Controller
{
    public function home()
    {
        echo 'Welcome to the Users API';
    }
    public function getUserData()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $id = $data['id'];
        $query = $this->database->read('SELECT id_usuario, id_tipo_usuario,nombre_completo, correo_usuario FROM usuario WHERE id_usuario = ?', [$id]);
        if (count($query) > 0) {
            echo $this->json->encode($query);
        } else {
            echo $this->json->encode(['message' => 'No se encontró ningún usuario con este ID.']);
        }
    }

    public function createUser()
    {
        try {
            $data = json_decode(file_get_contents('php://input'), true);
            // return $this->json->encode($data);
            if (empty($data['nombre_completo']) || empty($data['email']) || empty($data['password']) || empty($data['role'])) {
                echo $this->json->encode(['status' => 400, 'message' => 'Todos los campos son requeridos.']);
                return;
            } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                echo $this->json->encode(['status' => 400, 'message' => 'Correo electrónico inválido.']);
                return;
            } elseif (strlen($data['password']) < 6) {
                echo $this->json->encode(['status' => 400, 'message' => 'La contraseña debe tener al menos 6 caracteres.']);
                return;
            } elseif (strlen($data['nombre_completo']) < 3) {
                echo $this->json->encode(['status' => 400, 'message' => 'El nombre debe tener al menos 3 caracteres.']);
                return;
            } elseif (count($this->database->read('SELECT * FROM usuario WHERE correo_usuario = ?', [$data['email']])) > 0) {
                echo $this->json->encode(['status' => 400, 'message' => 'Alguien más ya está usando este correo electrónico. Intente con otro.']);
                return;

                
            } else {
                $name = $data['nombre_completo'];
                $email = $data['email'];
                $password = $data['password'];
                $rol = $data['role'];
                $query = $this->database->create('INSERT INTO usuario (id_tipo_usuario, nombre_completo, correo_usuario, contrasena) VALUES (?, ?, ?, ?)', [$rol, $name, $email, $password]);
                echo $this->json->encode(['status' => 200, 'message' => 'Usuario creado correctamente.']);
            }
        } catch (\PDOException $e) {
            echo $this->json->encode(['status' => 400, 'message' => 'Error al crear usuario.', $e->getMessage()]);
        }
    }

    public function updateUser()
    {
        try {
            $data = json_decode(file_get_contents('php://input'), true);
            $id = $data['id'];
            $name = $data['nombre_completo'];
            $email = $data['email'];
            $rol = $data['role'];
            $query = $this->database->update('UPDATE usuario SET id_tipo_usuario = ?, nombre_completo = ?, correo_usuario = ? WHERE id_usuario = ?', [$rol, $name, $email, $id]);
            echo $this->json->encode(['status' => 200, 'message' => 'Usuario actualizado correctamente.']);
        } catch (\PDOException $th) {
            echo $this->json->encode(['status' => 400, 'message' => 'Error al actualizar usuario.']);
        }
    }
    public function listUsers()
    {
        try {
            $query = $this->database->read('SELECT id_usuario, id_tipo_usuario,nombre_completo, correo_usuario FROM usuario', []); // fetch all posts
            if (count($query) > 0) {
                foreach ($query as &$user) {
                    switch ($user['id_tipo_usuario']) {
                        case 1:
                            $user['rol'] = 'administrador';
                            break;
                        case 2:
                            $user['rol'] = 'tecnico';
                            break;
                        case 3:
                            $user['rol'] = 'cliente';
                            break;


                            case 4:
                                $user['rol'] = 'secretaria';
                                break;
                        default:
                            $user['rol'] = 'desconocido';
                            break;
                    }
                }

                echo $this->json->encode($query);
            } else {
                echo $this->json->encode(['message' => 'No hay usuarios registrados.']);
            }
        } catch (\PDOException $e) {
            echo $this->json->encode(['message' => 'Error al obtener usuarios.']);
        }
    }

    public function countData()
    {
        $queryUsers = $this->database->read('SELECT COUNT(*) as count FROM usuario', []);
        $queryProducts = $this->database->read('SELECT COUNT(*) as count FROM producto', []);

        $countUsers = $queryUsers[0]['count'];
        $countProducts = $queryProducts[0]['count'];

        echo $this->json->encode([
            'countUsers' => $countUsers,
            'countProducts' => $countProducts,
        ]);
    }
    public function login()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $email = $data['email'];
        $password = $data['password'];

        if (empty($email) || empty($password)) {
            echo $this->json->encode(['status' => 400, 'message' => 'Todos los campos son requeridos.']);
            return;
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo $this->json->encode(['status' => 400, 'message' => 'Correo electrónico inválido.']);
            return;
        } elseif (strlen($password) < 6) {
            echo $this->json->encode(['status' => 400, 'message' => 'La contraseña debe tener al menos 6 caracteres.']);
            return;
        } elseif (count($this->database->read('SELECT * FROM usuario WHERE correo_usuario = ?', [$email])) == 0) {
            echo $this->json->encode(['status' => 400, 'message' => 'No se encontró ningún usuario con este correo electrónico.']);
            return;
        }

        $query = $this->database->read('SELECT id_tipo_usuario, id_usuario, nombre_completo, correo_usuario FROM usuario WHERE correo_usuario = ? AND contrasena = ?', [$email, $password]); // fetch all posts (id_tipo_usuario, nombre_completo, correo_usuario)
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
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo $this->json->encode(['status' => 400, 'message' => 'Correo electrónico inválido.']);
            return;
        } elseif (strlen($password) < 6) {
            echo $this->json->encode(['status' => 400, 'message' => 'La contraseña debe tener al menos 6 caracteres.']);
            return;
        } elseif (strlen($name) < 3) {
            echo $this->json->encode(['status' => 400, 'message' => 'El nombre debe tener al menos 3 caracteres.']);
            return;
        } elseif (count($this->database->read('SELECT * FROM usuario WHERE correo_usuario = ?', [$email])) > 0) {
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

    public function deleteUser()
    {
        try {
            $data = json_decode(file_get_contents('php://input'), true);
            $id = $data['id'];
            $query = $this->database->delete('DELETE FROM usuario WHERE id_usuario = ?', [$id]);
            echo $this->json->encode(['status' => 200, 'message' => 'Usuario eliminado correctamente.']);
        } catch (\PDOException $e) {
            echo $this->json->encode(['status' => 400, 'message' => 'Error al eliminar usuario.']);
        }
    }
}
