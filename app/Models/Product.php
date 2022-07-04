<?php

namespace app\Models;

require_once 'core/Connection.php';

use PDO;
use core\Connection;

class Product extends Connection {

	public function index($category){

        $query = "SELECT * FROM productos
        
        WHERE categoria_id = $category AND visible = 1";

        $stmt = $this->pdo->prepare($query);
        $result = $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }
    public function categoria($category){

        $query = "SELECT
        productos_categorias.nombre AS categoria
        FROM productos_categorias
        -- INNER JOIN productos_categorias ON productos.categoria_id = productos_categorias.id 
        WHERE productos_categorias.id = $category";

        $stmt = $this->pdo->prepare($query);
        $result = $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);

    }
}

?>