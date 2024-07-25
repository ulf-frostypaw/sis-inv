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
        $nameProduct = $data['nameProduct'];
        // $descriptionProduct = $data['descriptionProduct'];
        $stock = $data['stock'];
        $costPrice = $data['costPrice'];
        $costSale = $data['costSale'];
        $category = $data['category'];

        try {
            $query = $this->database->create('INSERT INTO producto (nombre_producto, stock, precio_costo, precio_venta, categoria) VALUES (?, ?, ?, ?, ?)', [$nameProduct, $stock, $costPrice, $costSale, $category]); // fetch all posts

            return $this->json->encode(['message' => 'Producto registrado correctamente.']);
        } catch (\PDOException $th) {
            return $this->json->encode(['message' => 'Error al registrar producto.', 'error' => $th->getMessage()]);
        }
    }

    public function updateProduct()
    { // esto retorna el producto unico
        try {
            $data = json_decode(file_get_contents('php://input'), true);
            $this->database->update('UPDATE producto SET nombre_producto = ?, stock = ?, precio_costo = ?, precio_venta = ?, categoria = ? WHERE id_producto = ?', [$data['nameProduct'], $data['stock'], $data['costPrice'], $data['costSale'], $data['category'], $data['id_producto']]);
            return $this->json->encode(['message' => 'Producto actualizado correctamente.']);
        } catch (\PDOException $th) {
            return $this->json->encode(['message' => 'Sucedió un error al intentar actualizar el producto.', 'error' => $th->getMessage()]);
        }
    }


    public function deleteProduct()
    {
        try {
            $this->database->delete("DELETE FROM producto WHERE id_producto = ?", ['id_producto']);
            return $this->json->encode(['message' => 'Producto eliminado correctamente.']);

        } catch (\Throwable $th) {
            return $this->json->encode(['message' => 'Error al eliminar producto.', 'error' => $th->getMessage()]);
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
