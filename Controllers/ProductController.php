<?php

namespace Controllers;


class ProductController extends Controller
{
    public function listOneProduct($params){
        $productParts = explode('/', $params['id']);
        
        $query = $this->database->read('SELECT * FROM producto WHERE id_producto = ?', [$productParts[2]]); // fetch all posts
        if (count($query) > 0) {
            echo $this->json->encode($query);
        } else {
            echo $this->json->encode(['message' => 'No hay productos disponibles.']);
        }
    }
    public function listProduct()
    {
        $query = $this->database->read('SELECT * FROM producto', []); // fetch all posts
        if (count($query) > 0) {
            echo $this->json->encode($query);
        } else {
            echo $this->json->encode(['message' => 'No hay productos disponibles.']);
        }
    }
    public function addProduct()
    {

        $data = json_decode(file_get_contents('php://input'), true);
        $nameProduct = $data['nombre_producto'];
        $descriptionProduct = $data['descripcion'];
        $stock = $data['stock'];
        $costPrice = $data['precio_costo'];
        $costSale = $data['precio_venta'];
        $category = $data['categoria'];

        try {
            $query = $this->database->create('INSERT INTO producto (nombre_producto, stock,descripcion, precio_costo, precio_venta, categoria) VALUES (?, ?, ?, ?, ?, ?)', [$nameProduct, $stock, $descriptionProduct,  $costPrice, $costSale, $category]); // fetch all posts

            return $this->json->encode(['status' => 200, 'message' => 'Producto registrado correctamente.']);
        } catch (\PDOException $th) {
            return $this->json->encode(['status' => 400, 'message' => 'Error al registrar producto.', 'error' => $th->getMessage()]);
        }
    }

    public function updateProduct()
    { // esto retorna el producto unico
        try {
            $data = json_decode(file_get_contents('php://input'), true);
            $this->database->update('UPDATE producto SET nombre_producto = ?, stock = ?, precio_costo = ?, precio_venta = ?, categoria = ? WHERE id_producto = ?', [$data['nombre_producto'], $data['stock'], $data['precio_costo'], $data['precio_venta'], $data['categoria'], $data['id_producto']]);
            return $this->json->encode(['status' => 200, 'message' => 'Producto actualizado correctamente.']);
        } catch (\PDOException $th) {
            return $this->json->encode(['status' => 400 , 'message' => 'Sucedió un error al intentar actualizar el producto.', 'error' => $th->getMessage()]);
        }
    }


    public function deleteProduct()
    {
        try {
            $data = json_decode(file_get_contents('php://input'), true);
            $this->database->delete("DELETE FROM producto WHERE id_producto = ?", [$data['id']]);
            return $this->json->encode(['status' => 200, 'message' => 'Producto eliminado correctamente.']);

        } catch (\Throwable $th) {
            return $this->json->encode(['status' => 400, 'message' => 'Error al eliminar producto.', 'error' => $th->getMessage()]);
        }
    }

    public function viewProduct()
    {
        echo 'ProductController view';
    }

    public function searchProduct()
    {
        echo 'ProductController search';
    }
}
