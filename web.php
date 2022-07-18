<?php

    require_once 'app/Controllers/TicketController.php';
    require_once 'app/Controllers/TableController.php';
    require_once 'app/Controllers/VentaController.php';
    require_once 'app/Controllers/PaymentMethodController.php';
    require_once 'app/Controllers/IvaController.php';
    require_once 'app/Controllers/ProductCategoryController.php';

  
    use app\Controllers\TicketController;
    use app\Controllers\TableController;
    use app\Controllers\VentaController;
    use app\Controllers\PaymentMethodController;
    use app\Controllers\IvaController;
    use app\Controllers\ProductCategoryController;

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

            case 'storeTable':

                $table = new TableController();

                $new_table = $table->store($json->id, $json->numero, $json->ubicacion, $json->pax);

                $response = array(
                    'status' => 'ok',
                    'id' => $json->id,
                    'newElement' => $new_table
                );

                echo json_encode($response);

                break;
            
            case 'showTable':

                $table = new TableController();
                $table = $table->show($json->id);

                $response = array(
                    'status' => 'ok',
                    'element' => $table,
                );

                echo json_encode($response);

                break;
            
            case 'deleteTable':

                $table = new TableController();
                $table->delete($json->id);

                $response = array(
                    'status' => 'ok',
                    'id' => $json->id
                );

                echo json_encode($response);

                break;

                case 'storePaymentMethod':

                    $pago = new PaymentMethodController();
    
                    $new_pago = $pago->store($json->id, $json->nombre);
    
                    $response = array(
                        'status' => 'ok',
                        'id' => $json->id,
                        'newElement' => $new_pago
                    );
    
                    echo json_encode($response);
    
                    break;
                
                case 'showPaymentMethod':
    
                    $pago = new PaymentMethodController();
                    $pago = $pago->show($json->id);
    
                    $response = array(
                        'status' => 'ok',
                        'element' => $pago,
                    );
    
                    echo json_encode($response);
    
                    break;
                
                case 'deletePaymentMethod':
    
                    $pago = new PaymentMethodController();
                    $pago->delete($json->id);
    
                    $response = array(
                        'status' => 'ok',
                        'id' => $json->id
                    );
    
                    echo json_encode($response);
    
                    break;    
                
                    case 'storeIva':

                        $iva = new IvaController();
        
                        $new_iva = $iva->store($json->id, $json->tipo, $json->vigente);
        
                        $response = array(
                            'status' => 'ok',
                            'id' => $json->id,
                            'newElement' => $new_iva
                        );
        
                        echo json_encode($response);
        
                        break;
                    
                    case 'showIva':
        
                        $iva = new IvaController();
                        $iva = $iva->show($json->id);
        
                        $response = array(
                            'status' => 'ok',
                            'element' => $iva,
                        );
        
                        echo json_encode($response);
        
                        break;
                    
                    case 'deleteIva':
        
                        $iva = new IvaController();
                        $iva->delete($json->id);
        
                        $response = array(
                            'status' => 'ok',
                            'id' => $json->id
                        );
        
                        echo json_encode($response);
        
                        break;

                        case 'storeCategoria':

                            $productcategory = new ProductCategoryController();
            
                            $new_categoria = $productcategory->store($json->id, $json->nombre);
            
                            $response = array(
                                'status' => 'ok',
                                'id' => $json->id,
                                'newElement' => $new_categoria
                            );
            
                            echo json_encode($response);
            
                            break;
                        
                        case 'showCategoria':
            
                            $productcategory = new ProductCategoryController();
                            $categoria = $productcategory->show($json->id);
            
                            $response = array(
                                'status' => 'ok',
                                'element' => $categoria,
                            );
            
                            echo json_encode($response);
            
                            break;
                        
                        case 'deleteCategoria':
            
                            $productcategory = new ProductCategoryController();
                            $productcategory->delete($json->id);
            
                            $response = array(
                                'status' => 'ok',
                                'id' => $json->id
                            );
            
                            echo json_encode($response);
            
                            break;
                            
                            case 'storeCategoria':

                                $product = new ProductController();
                                $productcategory = new ProductCategoryController();
                
                                $new_product = $product->store($json->id, $json->nombre, $json->categoria);
                
                                $response = array(
                                    'status' => 'ok',
                                    'id' => $json->id,
                                    'newElement' => $new_product
                                );
                
                                echo json_encode($response);
                
                                break;
                            
                            case 'showProduct':
                
                                $product = new ProductController();
                                $product = $product->show($json->id);
                
                                $response = array(
                                    'status' => 'ok',
                                    'element' => $categoria,
                                );
                
                                echo json_encode($response);
                
                                break;
                            
                            case 'deleteProduct':
                
                                $product = new ProductController();
                                $product->delete($json->id);
                
                                $response = array(
                                    'status' => 'ok',
                                    'id' => $json->id
                                );
                
                                echo json_encode($response);
                
                                break;           
                    
        }

    } else {
        echo json_encode(array('error' => 'No action'));
    }    
?>