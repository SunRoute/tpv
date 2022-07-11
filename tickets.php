<?php

    require_once 'app/Controllers/TicketController.php';
    require_once 'app/Controllers/TableController.php';

    use app\Controllers\TicketController;
    use app\Controllers\TableController;

    $ticket = new TicketController();
    $mesa = new TableController();

    if (isset($_GET['mesa'])){
        $tickets = $ticket->index($_GET['mesa']);
        $total = $ticket->total($_GET['mesa']);
        $numero_mesa = $mesa->numero($_GET['mesa']);
        
    };
    $forma_pago = $ticket->formaPago();
        
?>

<div class="col-12 col-lg-5 col-xl-4 mt-5">
    <aside>
        <?php if(!empty($numero_mesa)):?>
            <h2 class="text-center">TICKET MESA <?= $numero_mesa['numero']; ?></h2>
        <?php else: ?>
            <h2 class="text-center">TICKET</h2>    
        <?php endif; ?>
        <ul class="list-group shadow mt-4">
            <?php if(!empty($tickets)):?>
                <?php foreach($tickets as $ticket):?>
                    <li class="list-group-item d-flex align-items-center"><button class="delete-product btn btn-light btn-sm me-2" data-table="<?php echo $_GET['mesa'] ?>" data-ticket="<?= $ticket['ticket_id'];?>" type="button"><i class="la la-close"></i></button><img class="img-ticket" src="<?= $ticket['imagen']; ?>">
                        <div class="flex-grow-1"><span class="categoria-prod"><?= $ticket['categoria']; ?></span>
                            <h4 class="nombre-prod mb-0"><?= $ticket['producto']; ?></h4>
                        </div>
                        <p class="precio-prod"><?= $ticket['base']; ?></p>
                    </li>
                <?php endforeach;?>
            <?php else: ?>
                <h4><?php echo "No hay seleccionado ningún producto"?></h4> 
            <?php endif; ?>
        </ul>
        <div class="row mt-3">
            <div class="col">
                <div class="bg-secondary">
                    <div class="row justify-content-between g-0">
                        <div class="col">
                            <h5 class="text-center text-white mb-0 pt-1">B. Imponible</h5>
                        </div>
                        <div class="col">
                            <?php if (!empty($total)):?>
                                <h5 class="text-center text-white mb-0 border-start pt-1">IVA (<?= $total['iva'] ?>%)</h5>
                            <?php else:?>
                                <h5 class="text-center text-white mb-0 border-start pt-1">IVA (-)</h5>
                            <?php endif; ?>
                        </div>
                        <div class="col">
                            <h5 class="text-center text-white mb-0 bg-dark pt-1">TOTAL</h5>
                        </div>
                    </div>
                    <div class="row justify-content-between g-0">
                        <?php if (!empty($total)):?>
                            <div class="col">
                                <h5 class="text-center text-white mb-0 pb-1"><?= $total['base']; ?>€</h5>
                            </div>
                        <?php else:?>
                            <div class="col">
                                <h5 class="text-center text-white mb-0 pb-1">0€</h5>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($total)):?>
                            <div class="col">
                                <h5 class="text-center text-white mb-0 border-start pb-1"><?= $total['total_iva']; ?>€</h5>
                            </div>
                        <?php else:?>
                            <div class="col">
                                <h5 class="text-center text-white mb-0 pb-1"> 0€ </h5>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($total)):?>
                            <div class="col">
                                <h5 class="text-center text-white mb-0 bg-dark pb-1"><?= $total['precio_total']; ?>€</h5>
                            </div>
                            <?php else:?>
                            <div class="col">
                                <h5 class="text-center text-white mb-0 pb-1"> 0€ </h5>
                            </div>
                        <?php endif; ?>    
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3 mb-3">
            <div class="col-6">
                <div><a class="btn btn-danger btn-lg w-100" role="button" href="#myModal" data-bs-toggle="modal">ELIMINAR</a>
                    <div class="modal fade" role="dialog" tabindex="-1" id="myModal">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4>Eliminar ticket</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p class="text-center text-muted">Está a punto de borrar el pedido sin ser cobrado. ¿Está completamente seguro de realizar esta acción?</p>
                                </div>
                                <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">CERRAR</button><button class="delete-all btn btn-success" data-table="<?php echo $_GET['mesa'] ?>" type="button">ELIMINAR</button></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div><a class="btn btn-success btn-lg w-100" role="button" href="#myModal-2" data-bs-toggle="modal">COBRAR</a>
                    <div class="modal fade" role="dialog" tabindex="-1" id="myModal-2">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4>Metodo de pago</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <?php foreach($forma_pago as $forma_pago):?> 
                                    <div class="modal-body">
                                        <div class="row align-items-center flex-column">
                                            <div class="col-6 d-lg-flex m-2"><button class="cobrar btn btn-primary w-100" data-base="<?= $total['base']; ?>" data-iva="<?= $total['total_iva']; ?>" data-precio_total="<?= $total['precio_total']; ?>" data-pago="<?= $forma_pago['pago_id']; ?>" data-table="<?php echo $_GET['mesa'] ?>" type="button"><?= $forma_pago['forma_pago']; ?></button></div>
                                        </div>
                                    </div>
                                <?php endforeach;?>
                                <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">CERRAR</button></div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </aside>
</div>