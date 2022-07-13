<?php

    require_once 'app/Controllers/TicketController.php';
    require_once 'app/Controllers/TableController.php';
    require_once 'app/Controllers/VentaController.php';
  
    use app\Controllers\TicketController;
    use app\Controllers\TableController;
    use app\Controllers\VentaController;

    header("Content-Type: application/json");

    if(isset($_GET['data'])){
        $json = json_decode($_GET['data']);
    }else{
        $json = json_decode(file_get_contents('php://input'));
    }
    // se capturan los datos en variable json 


    if(isset($json->route)) {

        switch($json->route) {

            case 'addProduct':

                $ticket = new TicketController();
                $table = new TableController();

                $newProduct = $ticket->addProduct($json->price_id, $json->table_id);
                $total = $ticket->total($json->table_id);
                $table->actualizar(0, $json->table_id);

                $response = array(
                    'status' => 'ok',
                    'total' => $total,
                    'newProduct' => $newProduct,
                );

                echo json_encode($response);

                break;

            case 'deleteProduct':

                $ticket = new TicketController();
                $table = new TableController();

                $deleteProduct = $ticket->deleteProduct($json->ticket_id);
                $total = $ticket->total($json->table_id);

                if(empty($total)){
                    $table->actualizar(1, $json->table_id);
                }
                
                $response = array(
                    'status' => 'ok',
                    'total' => $total,
                );

                echo json_encode($response);

                break;

            case 'deleteAll':

                $ticket = new TicketController();
                $table = new TableController();

                $deleteAll = $ticket->deleteAll($json->table_id);
                $total = $ticket->total($json->table_id);

                $table->actualizar(1, $json->table_id);
                
                $response = array(
                    'status' => 'ok',
                    'total' => $total,
                );

                echo json_encode($response);

                break;
                    
            case 'cobrar':

                $ticket = new TicketController();
                $table = new TableController();
                $venta = new VentaController();

                $total = $ticket->total($json->table_id);
                $venta_id = $venta->cobrar($total['base'], $total['total_iva'], $total['precio_total'], $json->pago_id, $json->table_id);
                $ventaCerrada = $ticket->ventaCerrada($json->table_id, $venta_id);
                $creacion_ticket = $ticket->ultimoTicketCreado($venta_id);
                $ocupacion = $venta->ocupacion($venta_id, $creacion_ticket['creado']);

                $table->actualizar(1, $json->table_id);
                    
                $response = array(
                    'status' => 'ok',
                );
    
                echo json_encode($response);
    
                break;
                 
        }

    } else {
        echo json_encode(array('error' => 'No action'));
    }    
?>