<?php

    require_once 'app/Controllers/VentaController.php';

    use app\Controllers\VentaController;

    $venta = new VentaController();

    $ventas = $venta->index();

    if(!empty($_GET['venta'])){
        $detalles = $venta->detalle($_GET['venta']);
    } 
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>diseño tpv</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/Abel.css">
    <link rel="stylesheet" href="assets/fonts/ionicons.min.css">
    <link rel="stylesheet" href="assets/fonts/line-awesome.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="text-center mt-3 border titular">TPV</h1>
            </div>
            <div class="col-12 col-lg-7 col-xl-8 order-lg-1 mt-5">
                <section>
                
                <?php if( isset($_GET['venta'])): ?> 
                    <h2 class="text-center">VENTA <?= $detalles['ticket']; ?></h2>

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Datos de la venta</h5>
                                    <p class="card-text">
                                        <strong>Mesa: </strong><?= $detalles['mesa']; ?><br>
                                        <strong>Método de pago: </strong><?= $detalles['forma_pago']; ?><br>
                                        <strong>Total base: </strong><?= $detalles['base']; ?>€<br>
                                        <strong>Total IVA:</strong><?= $detalles['iva']; ?>€<br>
                                        <strong>Total:</strong><?= $detalles['total']; ?>€
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>    
                </section>
            </div>

            <div class="col-12 col-lg-5 col-xl-4 mt-5">
                <aside>
                    <h2 class="text-center">VENTAS</h2>

                    <div class="list-group">
                    <?php foreach($ventas as $venta):?>
                        <a class="sale-item list-group-item list-group-item-action" href="ventas.php?venta=<?= $venta['id']?>" aria-current="true">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1">Ticket: <?= $venta['ticket']; ?></h5>
                                <small>Hora: <?= $venta['hora']; ?></small>
                                <small>Mesa: <?= $venta['mesa']; ?></small>
                            </div>
                            <p class="mb-1"><?= $venta['total']; ?> €</p>
                        </a>
                    <?php endforeach;?>

                        <!-- <a class="sale-item list-group-item list-group-item-action active" href="ventas.php?venta=2" aria-current="true">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1">Ticket: 202206280002</h5>
                                <small>Hora:  17:58</small>
                                <small>Mesa: 1</small>
                            </div>
                            <p class="mb-1">30 €</p>
                        </a>

                        <a class="sale-item list-group-item list-group-item-action" href="ventas.php?venta=3" aria-current="true">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1">Ticket: 202206280003</h5>
                                <small>Hora: 18:00</small>
                                <small>Mesa: 3</small>
                            </div>
                            <p class="mb-1">72 €</p>
                        </a> -->
                    </div>
                </aside>
            </div>

        </div>
    </div>

    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>