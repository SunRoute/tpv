<?php

    require_once 'app/Controllers/TicketController.php';
  
    use app\Controllers\TicketController;

    header("Content-Type: application/json");

    if(isset($_GET['data'])){
        $json = json_decode($_GET['data']);
    }else{
        $json = json_decode(file_get_contents('php://input'));
    }
    // se capturan los datos en variable json 


    if(isset($json->route)) {

        // switch($json->route) {

        //     case 'addProduct':

        //         $ticket = new TicketController();

        //         $newProduct = $ticket->addProduct($json->price_id, $json->table_id);

        //         $response = array(
        //             'status' => 'ok',
        //             'newProduct' => $newProduct,
        //         );

        //         echo json_encode($response);

        //         break;
        // }

    } else {
        echo json_encode(array('error' => 'No action'));
    }    
?>