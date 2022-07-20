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

    public function administracionProductos(){

        $query = "SELECT productos.id AS id, productos.nombre AS nombre, productos.imagen_url AS imagen_url, productos.visible AS visible, productos_categorias.nombre AS categoria, precios.precio_base AS base, iva.tipo AS iva
        FROM productos
        INNER JOIN productos_categorias ON productos.categoria_id = productos_categorias.id
        INNER JOIN precios ON precios.producto_id = productos.id
        INNER JOIN iva ON precios.iva_id = iva.id
        WHERE productos.activo = 1";

        $stmt = $this->pdo->prepare($query);
        $result = $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    public function store($id, $nombre, $categoria, $visible, $imagen_url ){
            
        if(empty($id)){
            $query = "INSERT INTO productos (nombre, categoria_id, imagen_url, visible, activo, creado, actualizado)
            VALUES ('$nombre', $categoria, '$imagen_url', $visible, 1, NOW(), NOW())";
            
            $stmt = $this->pdo->prepare($query);
            $result = $stmt->execute();
            $id = $this->pdo->lastInsertId();


        }else{
            $query = "UPDATE productos SET nombre = '$nombre', categoria_id = $categoria, visible= $visible, imagen_url = '$imagen_url', actualizado = NOW()
            WHERE id = $id";

            $stmt = $this->pdo->prepare($query);
            $result = $stmt->execute();
            
        }

        return $id;

    }

    public function show($product){

        $query = "SELECT productos.id AS id, productos.nombre AS nombre, productos.imagen_url AS imagen_url, productos.visible AS visible, productos_categorias.id AS categoria_id, productos_categorias.nombre AS categoria, precios.precio_base AS base, iva.id AS iva_id, iva.tipo AS iva
        FROM productos
        INNER JOIN productos_categorias ON productos.categoria_id = productos_categorias.id
        INNER JOIN precios ON precios.producto_id = productos.id
        INNER JOIN iva ON precios.iva_id = iva.id
        WHERE productos.activo = 1 AND productos.id = $product";
        
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

}

?>