<?php

    $tickets = ['2205290001', '2205290002', '2206150001'];

    function generarTicket($tickets){
       
        $fecha = date("ymd");
        $ultimo_ticket = end($tickets);
        $posTicket = strpos($ultimo_ticket, $fecha);
        
        if($posTicket !== false){
            echo $ultimo_ticket + 1;
        }else{
            echo $fecha."0001";
        }

    }

    generarTicket($tickets);

?>