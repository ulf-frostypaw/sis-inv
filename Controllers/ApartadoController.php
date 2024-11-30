<?php

namespace Controllers;

class ApartadoController extends Controller
{

    public function deleteApartado(){
        $data = json_decode(file_get_contents('php://input'), true);
        
        try {
            $query = $this->database->delete(
                "DELETE FROM apartados WHERE id_apartado = ?",
                [
                    $data['id']
                ]
            );
            return $this->json->encode(['status' => 200, 'message' => 'Apartado eliminado correctamente.']);
        } catch (\PDOException $th) {
            return $this->json->encode(['message' => 'Error al eliminar apartado.', 'error' => $th->getMessage()]);
        }
    }

    public function atenderApartado(){
        $data = json_decode(file_get_contents('php://input'), true);
        try {
            $query = $this->database->update(
                "UPDATE apartados SET status = ? WHERE id_apartado = ?",
                [
                    1, // Status 1 = Activo
                    $data['id']
                ]
            );
            return $this->json->encode(['status' => 200, 'message' => 'Apartado atendido correctamente.']);
        } catch (\PDOException $th) {
            return $this->json->encode(['message' => 'Error al atender apartado.', 'error' => $th->getMessage()]);
        }
    }

    public function listApartados()
    {
        try {
            $query = $this->database->read(
                "SELECT a.id_apartado, a.id_producto, a.status, a.status1, a.id_cliente, a.fecha_apartado, u.nombre_completo
                FROM apartados a 
                INNER JOIN usuario u ON a.id_cliente = u.id_usuario"
            );
            return $this->json->encode(['status' => 200, 'data' => $query]);
        } catch (\PDOException $th) {
            return $this->json->encode(['message' => 'Error al listar apartados.', 'error' => $th->getMessage()]);
        }
    }
    public function apartar()
    {
        $data = json_decode(file_get_contents('php://input'), true);

        try {
            /* $userIdExists = $this->database->read('SELECT * FROM usuario WHERE id_cliente = ?', [$data['id_cliente']]);
            if (count($userIdExists) > 0) {
                $this->database->create(
                    
            } */
            $queryExist = $this->database->read('SELECT * FROM apartados WHERE id_producto = ? AND id_cliente = ?', [$data['id_producto'], $data['id_cliente']]);
            if (count($queryExist) > 0) {
                return $this->json->encode(['status' => 200, 'message' => 'Usted ya aparto este producto.']);
            } else {
                $query = $this->database->create(
                    "INSERT INTO apartados (id_producto, status, status1, id_cliente, fecha_apartado) VALUES (?, ?, ?, ?, ?)",
                    [
                        $data['id_producto'],
                        2, // Status 2 = Pendiende / revision
                        null, // Status 1 = Activo
                        $data['id_cliente'],
                        date('Y-m-d H:i:s')
                    ]
                );
                return $this->json->encode(['status' => 200, 'message' => 'Apartado correctamente.']);
            }
        } catch (\PDOException $th) {
            return $this->json->encode(['message' => 'Error al registrar apartado.', 'error' => $th->getMessage()]);
        }
        //return $this->json->encode(['message' => 'Apartado registrado correctamente.']);
    }
}
