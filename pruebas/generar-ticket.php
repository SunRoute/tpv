<?php

    $numero_ticket = [];

    function generarTicket($numero_ticket){

        $fecha = date("ymd");
        $ultimo_ticket = end($numero_ticket);
        $posTicket = strpos($ultimo_ticket, $fecha);

        if($posTicket !== false){
            echo $ultimo_ticket + 1;
        }else{
            echo $fecha."0001";
        }

    }

        generarTicket($numero_ticket);

?>

<!-- consulta base media:
SELECT SUM(precio_total) AS total, (SELECT ROUND(AVG(total),2) AS media_por_dia FROM (SELECT SUM(precio_total) AS total, DAYNAME(fecha_emision) AS dia FROM `ventas` WHERE activo= 1 GROUP BY fecha_emision) subconsulta WHERE dia = DAYNAME('2022-06-30') GROUP BY dia) AS media FROM `ventas` WHERE fecha_emision = '2022-06-30' AND activo= 1  -->