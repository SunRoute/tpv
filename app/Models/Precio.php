<?php

namespace app\Models;

require_once 'core/Connection.php';

use PDO;
use core\Connection;

class Precio extends Connection {   
    
    public function filtrarPrecios($new_product_id, $iva, $base){
    
        $query = "SELECT * FROM precios
        WHERE producto_id = $new_product_id AND vigente=1 AND (iva_id = $iva AND precio_base = $base)";

        $stmt = $this->pdo->prepare($query);
        $result = $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function store($new_product_id, $iva, $base){
            
        $query = "UPDATE precios SET vigente = 0
        WHERE producto_id = $new_product_id";

        $stmt = $this->pdo->prepare($query);
        $result = $stmt->execute();

        $query = "INSERT INTO precios (producto_id, iva_id, precio_base, vigente, activo, creado, actualizado)
        VALUES ($new_product_id, $iva, $base, 1, 1, NOW(), NOW())";
            
        $stmt = $this->pdo->prepare($query);
        $result = $stmt->execute();
        
        return 'ok';
    }

    public function delete($id){

        $query = "UPDATE precios SET activo=0, actualizado = NOW()
        WHERE producto_id = $id";

        $stmt = $this->pdo->prepare($query);
        $result = $stmt->execute();

    }

}

?>