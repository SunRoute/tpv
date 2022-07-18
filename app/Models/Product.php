<?php

namespace app\Models;

require_once 'core/Connection.php';

use PDO;
use core\Connection;

class Product extends Connection {

	public function index($category){

        $query = "SELECT productos.nombre, productos.imagen_url, precios.id AS precio_id
        FROM productos
        INNER JOIN precios ON precios.producto_id = productos.id
        WHERE categoria_id = $category AND visible = 1 AND precios.vigente = 1";

        $stmt = $this->pdo->prepare($query);
        $result = $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }
    public function categoria($category){

        $query = "SELECT
        productos_categorias.nombre AS categoria
        FROM productos_categorias
        
        WHERE productos_categorias.id = $category";

        $stmt = $this->pdo->prepare($query);
        $result = $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);

    }

    public function store($id, $nombre, $categoria, $visible){
            
        if(empty($id)){
            $query = "INSERT INTO productos (nombre, categoria_id, visible, activo, creado, actualizado)
            VALUES ('$nombre', $categoria, $visible, 1, NOW(), NOW())";
            
            $stmt = $this->pdo->prepare($query);
            $result = $stmt->execute();

            $query = "SELECT * FROM productos WHERE id =".$this->pdo->lastInsertId();

        }else{
            $query = "UPDATE productos SET nombre = '$nombre', categoria = $categoria, visible= $visible, actualizado = NOW()
            WHERE id = $id";

            $stmt = $this->pdo->prepare($query);
            $result = $stmt->execute();   

            $query = "SELECT * FROM productos WHERE id =".$id;
        }

        $stmt = $this->pdo->prepare($query);
        $result = $stmt->execute();
       
        return $stmt->fetch(PDO::FETCH_ASSOC);

    }

    public function show($product){

        $query = "SELECT * FROM productos
        WHERE id = $product";

        $stmt = $this->pdo->prepare($query);
        $result = $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function delete($id){

        $query = "UPDATE productos SET activo=0, actualizado = NOW()
        WHERE id = $id";

        $stmt = $this->pdo->prepare($query);
        $result = $stmt->execute();

    }

    public function administracion($id){

        $query = "SELECT productos.nombre AS nombre, productos.imagen_url AS imagen, productos.visible AS visible, productos_categorias.nombre AS categoria, precios.precio_base AS base, iva.tipo AS iva
        FROM productos
        INNER JOIN productos_categorias ON productos.categoria_id = productos_categorias.id
        INNER JOIN precios ON precios.producto_id = productos.id
        INNER JOIN iva ON precios.iva_id = iva.id
        WHERE id = $id";

        $stmt = $this->pdo->prepare($query);
        $result = $stmt->execute();

    }


}

?>