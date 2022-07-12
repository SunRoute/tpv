<?php

    namespace app\Models;

    require_once 'core/Connection.php';

    use PDO;
    use core\Connection;

    class Ticket extends Connection {

	    public function index($mesa){

            $query = "SELECT
            tickets.id AS ticket_id, productos.nombre AS producto, precios.precio_base AS base, productos_categorias.nombre AS categoria, productos.imagen_url AS imagen
            FROM tickets
            INNER JOIN precios ON tickets.precio_id = precios.id
            INNER JOIN productos ON precios.producto_id = productos.id
            INNER JOIN productos_categorias ON productos.categoria_id = productos_categorias.id
            WHERE mesa_id = $mesa AND tickets.activo = 1 AND venta_id IS NULL";

            $stmt = $this->pdo->prepare($query);
            $result = $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }

        public function total($table_id){

            $query = "SELECT
            round(SUM(precios.precio_base), 2)AS base,
            round(SUM(precios.precio_base*multiplicador), 2) AS precio_total,
            round(SUM(precios.precio_base*multiplicador), 2) - SUM(precios.precio_base) AS total_iva,
            iva.tipo AS iva
            FROM tickets 
            INNER JOIN precios ON tickets.precio_id = precios.id 
            INNER JOIN productos ON precios.producto_id = productos.id 
            INNER JOIN productos_categorias ON productos.categoria_id = productos_categorias.id
            INNER JOIN iva ON precios.iva_id = iva.id 
            WHERE mesa_id = $table_id AND tickets.activo = 1 AND venta_id IS NULL AND iva.activo = 1 GROUP BY iva.id";

            $stmt = $this->pdo->prepare($query);
            $result = $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function addProduct($price_id, $table_id){

            $query = "INSERT INTO tickets (precio_id, mesa_id, activo, creado, actualizado) VALUES (". $price_id.", ".$table_id.", 1, NOW(), NOW())";

            $stmt = $this->pdo->prepare($query);
            $result = $stmt->execute();
            $id = $this->pdo->lastInsertId();

            $query =  "SELECT tickets.id AS id, productos.nombre AS nombre, precios.precio_base AS precio_base, productos.imagen_url 
            AS imagen_url, productos_categorias.nombre AS categoria
            FROM tickets 
            INNER JOIN precios ON tickets.precio_id = precios.id 
            INNER JOIN productos ON precios.producto_id = productos.id 
            INNER JOIN productos_categorias ON productos.categoria_id = productos_categorias.id
            WHERE tickets.id = ".$id;

            $stmt = $this->pdo->prepare($query);
            $result = $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function deleteProduct($ticket_id){

            $query =  "UPDATE tickets SET activo= 0, actualizado = NOW() WHERE id = $ticket_id";
            
            $stmt = $this->pdo->prepare($query);
            $result = $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function deleteAll($table_id){

            $query =  "UPDATE tickets SET activo= 0, actualizado = NOW() WHERE mesa_id = $table_id AND venta_id IS NULL";
            
            $stmt = $this->pdo->prepare($query);
            $result = $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function formaPago(){

            $query = "SELECT id AS pago_id, nombre AS forma_pago
            FROM metodos_pagos
            WHERE metodos_pagos.id";

            $stmt = $this->pdo->prepare($query);
            $result = $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        
        public function ultimoTicketCreado($venta_id){

            $query = "SELECT creado FROM tickets WHERE venta_id = $venta_id LIMIT 1";

            $stmt = $this->pdo->prepare($query);
            $result = $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function ventaCerrada($table_id, $venta_id){

            $query = "UPDATE tickets SET venta_id = $venta_id, actualizado = NOW()
            WHERE mesa_id = $table_id AND venta_id IS NULL AND activo = 1";
           

            $stmt = $this->pdo->prepare($query);
            $result = $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);

        }
        
    }

    

?>