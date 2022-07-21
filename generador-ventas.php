<?php

    require_once 'app/Controllers/TicketController.php';
    require_once 'app/Controllers/VentaController.php';
    require_once 'app/Controllers/ProductController.php';
    require_once 'app/Controllers/TableController.php';
    require_once 'app/Controllers/PaymentMethodController.php';

    use app\Controllers\TicketController;
    use app\Controllers\VentaController;
    use app\Controllers\ProductController;
    use app\Controllers\TableController;
    use app\Controllers\PaymentMethodController;

    $ticket = new TicketController();
    $venta = new VentaController();
    $product = new ProductController();
    $table = new TableController();
    $payment_method = new PaymentMethodController();

    $products = $product->index();
    $tables = $table->index();
    $payment_methods = $payment_method->index();

    $total_tables = count($tables);
    $total_products = count($products);
    $total_payment_methods = count($payment_methods);

    for($i = 0; $i <= 100; $i++){

        $table_id = mt_rand(1, $total_tables);

        $start_date = strtotime('2018-01-01');
        $end_date = time();
        $random_date = mt_rand($start_date, $end_date);
        $date = date('Y-m-d', $random_date);
        $time = mt_rand(12,23).":".str_pad(mt_rand(0,59), 2, "0", STR_PAD_LEFT);
        $timestamp = date('Y-m-d H:i:s', strtotime($date." ".$time));
        $plus_random_timestamp = date('Y-m-d H:i:s', strtotime($timestamp." +". mt_rand(0,200)." minutes"));

        $add_ticket_products = mt_rand(1, 10);

        for($j = 0; $j <= $add_ticket_products; $j++){

            $product_id = mt_rand(0, ($total_products -1));
            $price_id = $products[$product_id]['precio_id'];

            $ticket->addFakeProduct($price_id, $table_id, $timestamp);
        }

        $payment_method_id = mt_rand(1, $total_payment_methods);

        
        $total = $ticket->total($table_id);

        $venta_id = $venta->fakeCobrar($total['base'], $total['total_iva'], $total['precio_total'], $payment_method_id, $table_id, $date, $time, $timestamp);
        $ventaCerrada = $ticket->ventaFakeCerrada($table_id, $venta_id, $plus_random_timestamp);
        $creacion_ticket = $ticket->ultimoTicketCreado($venta_id);
        $ocupacion = $venta->fakeOcupacion($venta_id, $creacion_ticket['creado'], $plus_random_timestamp);
    }
?>