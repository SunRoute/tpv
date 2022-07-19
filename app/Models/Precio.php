<?php

namespace app\Models;

require_once 'core/Connection.php';

use PDO;
use core\Connection;

class Precio extends Connection {   
    
    
    
    public function store($new_product_id){
            
            if(empty($new_product_id)){
                
                $query = "INSERT INTO precios (producto_id, iva_id, precio_base, vigente, activo, creado, actualizado)
                VALUES ('$new_product_id', $iva, $base, 1, 1, NOW(), NOW())";
                
                $stmt = $this->pdo->prepare($query);
                $result = $stmt->execute();
    
            }else{
                $query = "UPDATE precios SET iva_id = $iva, precio_base = $base, actualizado = NOW()
                WHERE producto_id = $new_product_id";
    
                $stmt = $this->pdo->prepare($query);
                $result = $stmt->execute();   
    
            }
    
            $stmt = $this->pdo->prepare($query);
            $result = $stmt->execute();
           
            return $stmt->fetch(PDO::FETCH_ASSOC);
    
        }
    
        public function delete($new_product_id){
    
            $query = "UPDATE precios SET activo=0, actualizado = NOW()
            WHERE producto_id = $new_product_id";
    
            $stmt = $this->pdo->prepare($query);
            $result = $stmt->execute();
    
        }

    }

?>