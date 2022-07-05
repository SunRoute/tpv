<?php

namespace app\Models;

require_once 'core/Connection.php';

use PDO;
use core\Connection;

class ProductCategory extends Connection {

	public function index(){

        $query = "SELECT productos_categorias.id, productos_categorias.nombre, productos_categorias.imagen_url
        FROM productos_categorias
        INNER JOIN productos ON productos.categoria_id = productos_categorias.id 
        WHERE productos.visible = 1 GROUP BY productos_categorias.id";

        $stmt = $this->pdo->prepare($query);
        $result = $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>