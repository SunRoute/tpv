<?php

    namespace app\Models;

    require_once 'core/Connection.php';

    use PDO;
    use core\Connection;

    class Venta extends Connection {

	    public function index(){

            $query = "SELECT
            ventas.id AS id, ventas.numero_ticket AS ticket, ventas.hora_emision AS hora, mesas.numero AS mesa, ventas.precio_total AS total, metodos_pagos.nombre AS pago
            FROM ventas
            INNER JOIN mesas ON ventas.mesa_id = mesas.id
            INNER JOIN metodos_pagos ON ventas.metodo_pago_id = metodos_pagos.id
            WHERE ventas.activo = 1";

            $stmt = $this->pdo->prepare($query);
            $result = $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function detalle($venta){

            $query = "SELECT
            ventas.id AS id,
            ventas.numero_ticket AS ticket, ventas.fecha_emision, ventas.hora_emision, ventas.mesa_id AS mesa, metodos_pagos.nombre AS forma_pago, ventas.precio_total_base AS base, ventas.precio_total_iva AS iva, ventas.precio_total AS total
            FROM ventas
            INNER JOIN metodos_pagos ON ventas.metodo_pago_id = metodos_pagos.id
            WHERE ventas.id = $venta AND ventas.activo = 1";

            $stmt = $this->pdo->prepare($query);
            $result = $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function pedido($venta){

            $query = "SELECT
            productos.imagen_url AS imagen, productos.nombre AS producto, SUM(precios.precio_base) AS base, COUNT(productos.id) AS cantidad
            FROM tickets
            INNER JOIN precios ON tickets.precio_id = precios.id
            INNER JOIN mesas ON tickets.mesa_id = mesas.id
            INNER JOIN ventas ON tickets.venta_id = ventas.id
            INNER JOIN productos ON precios.producto_id = productos.id
            WHERE ventas.id = $venta AND ventas.activo = 1 GROUP BY productos.id";

            $stmt = $this->pdo->prepare($query);
            $result = $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function filtro($fecha,$mesa){

    
            if($mesa == null){
                $query = "SELECT
                ventas.id AS id, ventas.numero_ticket AS ticket, ventas.hora_emision AS hora, mesas.numero AS mesa, ventas.precio_total AS total
                FROM ventas
                INNER JOIN mesas ON ventas.mesa_id = mesas.id
                WHERE ventas.fecha_emision = '$fecha'";
            }
            else{
                $query = "SELECT
                ventas.id AS id, ventas.numero_ticket AS ticket, ventas.hora_emision AS hora, mesas.numero AS mesa, ventas.precio_total AS total
                FROM ventas
                INNER JOIN mesas ON ventas.mesa_id = mesas.id
                WHERE ventas.fecha_emision = '$fecha'
                AND mesas.numero = $mesa";
            }

            $stmt = $this->pdo->prepare($query);
            $result = $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function total($fecha){

            $query = "SELECT SUM(precio_total) AS total, (SELECT ROUND(AVG(total),2) AS media_por_dia FROM (SELECT SUM(precio_total) AS total, DAYNAME(fecha_emision) AS dia FROM ventas WHERE activo= 1 GROUP BY fecha_emision) subconsulta WHERE dia = DAYNAME('$fecha') GROUP BY dia) AS media FROM ventas WHERE fecha_emision = '$fecha' AND activo= 1";

            $stmt = $this->pdo->prepare($query);
            $result = $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function ultimo_ticket(){

            $query = "SELECT numero_ticket AS numero_ticket FROM ventas ORDER BY id DESC
            LIMIT 1";

            $stmt = $this->pdo->prepare($query);
            $result = $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function cobrar($numero_ticket, $base, $iva, $precio_total, $pago, $table_id){

            $query = "INSERT INTO ventas (numero_ticket, precio_total_base, precio_total_iva, precio_total, metodo_pago_id, mesa_id, fecha_emision, hora_emision, activo, creado, actualizado) VALUES (".$numero_ticket.", ".$base.", ".$iva.", ".$precio_total.", ".$pago.", ".$table_id.", CURDATE(), CURTIME(), 1, NOW(), NOW())";

            $stmt = $this->pdo->prepare($query);
            $result = $stmt->execute();

            $id = $this->pdo->lastInsertId();
            
            return $id;
        }

        public function fakeCobrar($numero_ticket, $base, $iva, $precio_total, $pago, $table_id, $date, $time, $timestamp){

            $query = "INSERT INTO ventas (numero_ticket, precio_total_base, precio_total_iva, precio_total, metodo_pago_id, mesa_id, fecha_emision, hora_emision, activo, creado, actualizado) VALUES (".$numero_ticket.", ".$base.", ".$iva.", ".$precio_total.", ".$pago.", ".$table_id.", '$date', '$time', 1, '$timestamp', '$timestamp')";

            $stmt = $this->pdo->prepare($query);
            $result = $stmt->execute();

            $id = $this->pdo->lastInsertId();
            
            return $id;
        }

        public function ocupacion($venta_id, $creacion_ticket){

            $query = "UPDATE ventas SET duracion_servicio = TIMESTAMPDIFF(MINUTE,'$creacion_ticket', NOW())
            WHERE ventas.id = $venta_id";

            $stmt = $this->pdo->prepare($query);
            $result = $stmt->execute();
    
        }

        public function fakeOcupacion($venta_id, $creacion_ticket, $timestamp){

            $query = "UPDATE ventas SET duracion_servicio = TIMESTAMPDIFF(MINUTE,'$creacion_ticket', '$timestamp')
            WHERE ventas.id = $venta_id";

            $stmt = $this->pdo->prepare($query);
            $result = $stmt->execute();
    
        }
        
        public function getChartData($chart_data){

            switch($chart_data) {
                
                case 'sales_by_hour':
    
                    $query="SELECT HOUR(hora_emision) AS labels, COUNT(*) AS quantity, SUM(precio_total) AS data
                    FROM ventas
                    GROUP BY HOUR(hora_emision) ORDER BY HOUR(hora_emision) ASC"; 

                    break;
    
                case 'sales_by_day':

                    $query="SELECT DAYNAME(fecha_emision) AS labels, COUNT(*) AS quantity, SUM(precio_total) AS data
                    FROM ventas
                    GROUP BY DAYNAME(fecha_emision) ORDER BY FIELD(labels,'Lunes','Martes','Miércoles','Jueves','Viernes','Sábado', 'Domingo')"; 
    
                    break;
    
                case 'sales_by_month':

                    $query="SELECT MONTHNAME(fecha_emision) AS labels, COUNT(*) AS quantity, SUM(precio_total) AS data
                    FROM ventas
                    GROUP BY MONTHNAME(fecha_emision) ORDER BY FIELD(labels,'Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre')"; 
      
                    break;
    
                case 'sales_by_year':
                    
                    $query="SELECT YEAR(fecha_emision) AS labels, COUNT(*) AS quantity, SUM(precio_total) AS data
                    FROM ventas
                    GROUP BY YEAR(fecha_emision) ORDER BY YEAR(fecha_emision) ASC";

                    break;
    
                case 'popular_payment_methods':
                    
                    $query="SELECT metodos_pagos.nombre AS labels, COUNT(*) AS data
                    FROM ventas
                    INNER JOIN metodos_pagos ON ventas.metodo_pago_id = metodos_pagos.id
                    GROUP BY metodos_pagos.nombre";

                    break;
    
                case 'average_service_duration':
                    
                    $query="SELECT mesas.numero AS labels, ROUND(AVG(duracion_servicio),2) as data
                    FROM ventas
                    INNER JOIN mesas ON ventas.mesa_id = mesas.id
                    GROUP BY mesas.numero ORDER BY mesas.numero";

                    break;

                case 'average_by_day':
                
                    $query="SELECT DAYNAME(fecha_emision) AS labels, ROUND(AVG(precio_total),2) as data
                    FROM ventas
                    GROUP BY DAYNAME(fecha_emision) ORDER BY FIELD(labels,'Lunes','Martes','Miércoles','Jueves','Viernes','Sábado', 'Domingo')";

                    break;
                
                case 'average_by_month':
            
                    $query="SELECT MONTHNAME(fecha_emision) AS labels, ROUND(AVG(precio_total),2) as data
                    FROM ventas
                    GROUP BY MONTHNAME(fecha_emision) ORDER BY FIELD(labels,'Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre')";

                    break;

                case 'average_by_year':
        
                    $query="SELECT YEAR(fecha_emision) AS labels, ROUND(AVG(precio_total),2) as data
                    FROM ventas
                    GROUP BY YEAR(fecha_emision) ORDER BY YEAR(fecha_emision)";

                    break;
            }
        
            
            $stmt = $this->pdo->prepare($query);
            $result = $stmt->execute();
    
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        
    }

?>     