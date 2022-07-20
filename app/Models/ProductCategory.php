<?php

namespace app\Models;

require_once 'core/Connection.php';

use PDO;
use core\Connection;

class ProductCategory extends Connection {

	public function index(){

        $query = "SELECT productos_categorias.id AS id, productos_categorias.nombre AS nombre, productos_categorias.imagen_url AS imagen_url
        FROM productos_categorias
        INNER JOIN productos ON productos.categoria_id = productos_categorias.id 
        WHERE productos.visible = 1 GROUP BY productos_categorias.id";

        $stmt = $this->pdo->prepare($query);
        $result = $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function administracionCategorias(){

        $query = "SELECT productos_categorias.id, productos_categorias.nombre, productos_categorias.imagen_url
        FROM productos_categorias
        WHERE activo = 1";

        $stmt = $this->pdo->prepare($query);
        $result = $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function store($id, $nombre, $imagen_url ){
            
        if(empty($id)){
            $query = "INSERT INTO productos_categorias (nombre, imagen_url, activo, creado, actualizado)
            VALUES ('$nombre', '$imagen_url', 1, NOW(), NOW())";
            
            $stmt = $this->pdo->prepare($query);
            $result = $stmt->execute();

            $query = "SELECT * FROM productos_categorias WHERE id =".$this->pdo->lastInsertId();

        }else{
            $query = "UPDATE productos_categorias SET nombre = '$nombre', imagen_url = '$imagen_url', actualizado = NOW()
            WHERE id = $id";

            $stmt = $this->pdo->prepare($query);
            $result = $stmt->execute();   

            $query = "SELECT * FROM productos_categorias WHERE id =".$id;
        }

        $stmt = $this->pdo->prepare($query);
        $result = $stmt->execute();
       
        return $stmt->fetch(PDO::FETCH_ASSOC);

    }

    public function show($categoria){

        $query = "SELECT * FROM productos_categorias
        WHERE id = $categoria";

        $stmt = $this->pdo->prepare($query);
        $result = $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function delete($id){

        $query = "UPDATE productos_categorias SET activo=0, actualizado = NOW()
        WHERE id = $id";

        $stmt = $this->pdo->prepare($query);
        $result = $stmt->execute();

    }
}

?>