<?php

    namespace app\Models;

    require_once 'core/Connection.php';

    use PDO;
    use core\Connection;

    class Venta extends Connection {

	    public function index(){

            $query = "SELECT
            ventas.id AS id, ventas.numero_ticket AS ticket, ventas.hora_emision AS hora, ventas.mesa_id AS mesa, ventas.precio_total AS total
            FROM ventas
            
            WHERE activo = 1";

            $stmt = $this->pdo->prepare($query);
            $result = $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }

        public function detalle($venta){

            $query = "SELECT
             ventas.numero_ticket AS ticket, ventas.mesa_id AS mesa, metodos_pagos.nombre AS forma_pago, ventas.precio_total_base AS base, ventas.precio_total_iva AS iva, ventas.precio_total AS total
            FROM ventas
            INNER JOIN metodos_pagos ON ventas.metodo_pago_id = metodos_pagos.id
            WHERE ventas.id = $venta AND ventas.activo = 1";

            $stmt = $this->pdo->prepare($query);
            $result = $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);

        }
    }

?>     