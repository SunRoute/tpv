<?php

    namespace app\Models;

    require_once 'core/Connection.php';

    use PDO;
    use core\Connection;

    class Ticket extends Connection {

	    public function index($mesa){

            $query = "SELECT
            productos.nombre AS producto, precios.precio_base AS base, productos_categorias.nombre AS categoria, productos.imagen_url AS imagen 
            FROM tickets
            INNER JOIN precios ON tickets.precio_id = precios.id
            INNER JOIN productos ON precios.producto_id = productos.id
            INNER JOIN productos_categorias ON productos.categoria_id = productos_categorias.id
            WHERE mesa_id = $mesa AND tickets.activo = 1 AND venta_id IS NULL";

            $stmt = $this->pdo->prepare($query);
            $result = $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }

        public function total($mesa){

            $query = "SELECT
            round(SUM(precios.precio_base), 2)AS base,
            round(SUM(precios.precio_base*multiplicador), 2) AS precio_total 
            FROM tickets 
            INNER JOIN precios ON tickets.precio_id = precios.id 
            INNER JOIN productos ON precios.producto_id = productos.id 
            INNER JOIN productos_categorias ON productos.categoria_id = productos_categorias.id
            INNER JOIN iva ON iva.id = precios.iva_id
            WHERE mesa_id = $mesa AND tickets.activo = 1 AND venta_id IS NULL";

            $stmt = $this->pdo->prepare($query);
            $result = $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);

        }

    }

?>