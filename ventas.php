<?php

    require_once 'app/Controllers/VentaController.php';
    require_once 'app/Controllers/TableController.php';

    use app\Controllers\VentaController;
    use app\Controllers\TableController;

    $venta = new VentaController();
    $table = new TableController();

    $fecha= !empty($_GET['fecha']) ? $_GET['fecha']  : date('Y-m-d');
    $mesa = !empty($_GET['mesa']) ? $_GET['mesa'] : null;

    $ventas = $venta->filtro($fecha,$mesa);
    $totales = $venta->total($fecha);

    if(!empty($_GET['venta'])){
        $detalles = $venta->detalle($_GET['venta']);
        $pedidos = $venta->pedido($_GET['venta']);
    }
    
    $mesas = $table->index();
    
    
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
                
                    <?php if(isset($_GET['venta'])): ?> 

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

                    <?php else: ?> 

                        <h2 class="text-center">VENTA</h2>

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Datos de la venta</h5>
                                        <p class="card-text"><?php echo "No hay ningún ticket seleccionado" ?>

                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                    <?php endif; ?>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="text-center"scope="col"></th>
                                    <th class="text-center" scope="col">Nombre</th>
                                    <th class="text-center" scope="col">Precio Base</th>
                                    <th class="text-center" scope="col">Cantidad</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(isset($_GET['venta'])): ?>
                                    <?php foreach($pedidos as $pedido):?>
                                        <tr>
                                            <td class="text-center"><img class="img-ticket" src="<?= $pedido['imagen']; ?>"></td>
                                            <td class="text-center"><?= $pedido['producto']; ?></td>
                                            <td class="text-center"><?= $pedido['base']; ?>€</td>
                                            <td class="text-center"><?= $pedido['cantidad']; ?></td>
                                        </tr>
                                    <?php endforeach;?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                        
                          
                
                </section>
            </div>

            <div class="col-12 col-lg-5 col-xl-4 mt-5">
                <aside>
                    <h2 class="text-center">VENTAS</h2>

                    <form action="ventas.php" method="GET">

                        <div class="row mt-3 mb-3">
                            <div class="col-6">
                                <p>Filtrar por fecha:</p>
                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    <input type="date" name="fecha" value="<?php echo $fecha ?>" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3 mb-3">
                            <div class="col-6">
                                <p>Filtrar por mesa:</p>
                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    <select name="mesa" class="form-control">
                                            <option value="">Todas</option>

                                            <?php foreach($mesas as $numero_mesa):?>
                                                <option value="<?= $numero_mesa['numero']; ?>"
                                                <?= $numero_mesa['numero'] == $mesa ? 'selected':'' ?>><?= $numero_mesa['numero']; ?></option>
                                            <?php endforeach;?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3 mb-3">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary w-100">Filtrar</button>
                            </div>
                        </div>

                    </form>

                    <div class="list-group">
                        <?php foreach($ventas as $venta):?>
                            <?php if(isset($_GET['venta']) && $_GET['venta'] == $venta['id'] ): ?> 
                                <a class="sale-item list-group-item list-group-item-action active" href="ventas.php?venta=<?= $venta['id'] ?>&fecha=<?= $fecha ?>&mesa=<?= $mesa; ?>" aria-current="true">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1">Ticket: <?= $venta['ticket']; ?></h5>
                                        <small>Hora: <?= $venta['hora']; ?></small>
                                        <small>Mesa: <?= $venta['mesa']; ?></small>
                                    </div>
                                    <p class="mb-1"><?= $venta['total']; ?> €</p>
                                </a>
                            <?php else: ?> 
                                <a class="sale-item list-group-item list-group-item-action" href="ventas.php?venta=<?= $venta['id'] ?>&fecha=<?= $fecha ?>&mesa=<?= $mesa; ?>" aria-current="true">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1">Ticket: <?= $venta['ticket']; ?></h5>
                                        <small>Hora: <?= $venta['hora']; ?></small>
                                        <small>Mesa: <?= $venta['mesa']; ?></small>
                                    </div>
                                    <p class="mb-1"><?= $venta['total']; ?> €</p>
                                </a>  
                            <?php endif; ?>
                        <?php endforeach;?>
                    </div>
                    <div class="row mt-3">
                        <div class="col">
                            <div class="bg-secondary" id="refresh-price">
                                <div class="row justify-content-between g-0">
                                    <div class="col">
                                        <h5 class="text-center text-white mb-0 pt-1">Total ingresos día</h5>
                                    </div>
                                    <div class="col">
                                        <h5 class="text-center text-white mb-0 pt-1">Media día de la semana</h5>
                                    </div>
                                    <div class="row justify-content-between g-0">
                                        <div class="col">
                                            <h5 class="text-center text-white mb-0 pb-1">
                                                <?php if(!empty($venta['total'])): ?>
                                                    <?= $totales['total']; ?> €
                                                <?php else: ?>
                                                    0 €
                                                <?php endif; ?>
                                            </h5>
                                        </div>
                                        <div class="col">
                                            <h5 class="text-center text-white mb-0 border-start pb-1">
                                                <?php if(!empty($venta['total'])): ?>
                                                    <?= $totales['media']; ?> €
                                                <?php else: ?>
                                                    0 €
                                                <?php endif; ?>
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </aside>
            </div>

        </div>
    </div>

    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>