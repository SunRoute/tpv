<?php

	require_once 'app/Controllers/TrabajadorController.php';
    require_once 'app/Controllers/SucursalController.php';

	use app\Controllers\TrabajadorController;
    use app\Controllers\SucursalController;

	$trabajador = new TrabajadorController();
    $sucursal = new SucursalController();

	$trabajadores = $trabajador->index();
	$sucursales = $sucursal->index();

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body>

    <?php include('menu.php') ?>
    
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="text-center mt-3 border titular"><small class="small-admin">PANEL DE ADMINISTRACIÓN</small>TRABAJADORES</h1>
            </div>
            <div class="col-12 mt-5">
                <section>
                    <div class="row">
                        <div class="col d-flex justify-content-end">
                            <button type="button" class="create-form-button btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#addArticle">+ Añadir trabajador</button>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Apellidos</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Sucursal</th>
                                    <th scope="col">Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($trabajadores as $trabajador): ?>
                                        <tr class="table-element" data-element="<?= $trabajador['id'] ?>">
                                            <th scope="row" class="nombre">
                                                <?= $trabajador['nombre'] ?>
                                            </th>
                                            <td class="apellidos">
                                                <?= $trabajador['apellidos'] ?>
                                            </td>
                                            <td class="correo">
                                                <?= $trabajador['correo'] ?>
                                            </td>
                                            <td class="sucursal">
                                                <?= $trabajador['sucursal'] ?>
                                            </td>
                                            <!-- Ruta para mostrar y modificar un registro -->
                                            <td class="opciones">
                                                <button type="button" class="edit-table-button btn btn-success" data-bs-toggle="modal" data-id="<?= $trabajador['id'] ?>" data-route="showTrabajador" data-bs-target="#addArticle">
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                                <button type="button" class="delete-table-button btn btn-danger" data-id="<?= $trabajador['id'] ?>" data-bs-toggle="modal" data-bs-target="#deleteArticle">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    <!-- Este dato es invisible mediante d-none. Cada cajita tiene la misma clase que los inputs de la tabla. Clona en admin-form... Mientras exista la plantilla que tenga las mismas clases, se aplicarán los datos-->
                                    <tr class="create-layout table-element d-none" data-element="">
                                        <th scope="row" class="nombre"></th>
                                        <td class="apellidos"></td>
                                        <td class="correo"></td>
                                        <td class="sucursal"><?= $trabajador['sucursal'] ?></td>
                                        <td class="opciones">
                                            <button type="button" class="edit-table-button btn btn-success" data-bs-toggle="modal" data-id="" data-route="showTrabajador" data-bs-target="#addArticle">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                            <button type="button" class="delete-table-button btn btn-danger" data-id="" data-bs-toggle="modal" data-bs-target="#deleteArticle">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col">
                            <nav aria-label="Page navigation example">
                                <ul class="pagination justify-content-center">
                                    <li class="page-item">
                                    <a class="page-link" href="#" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                    </li>
                                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item">
                                    <a class="page-link" href="#" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </section>
            </div>

        </div>
    </div>
    <!-- Modal ADD ARTICLE-->
    <div>
        <div id="addArticle" class="modal fade" tabindex="-1" aria-labelledby="addArticleLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addArticleLabel">ADMINISTRAR TRABAJADOR</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Ruta para crear registro nuevo. Se dirige a su caso de web.php -->
                    <form class="admin-form" data-route="storeTrabajador">
                        <input type="hidden" name="id" value="">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" name="nombre" value="">
                        </div>
                        <div class="mb-3">
                            <label for="apellidos" class="form-label">Apellidos</label>
                            <input type="text" class="form-control" name="apellidos" value="">
                        </div>
                        <div class="mb-3">
                            <label for="correo" class="form-label">Email</label>
                            <input type="text" class="form-control" name="correo" value="">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" name="password" value="">
                        </div>
                        <div class="mb-3">
                            <label for="sucursal" class="form-label">Sucursal</label>
                            <select class="form-select" aria-label="Default select example" name="sucursal">
                                <option selected>Selecciona sucursal</option>
                                <?php foreach($sucursales as $sucursal):?>
                                    <option value="<?= $sucursal['id']; ?>"
                                    <?= $sucursal['nombre_comercial'] == $sucursal ? 'selected':'' ?>><?= $sucursal['nombre_comercial']; ?></option>
                                <?php endforeach;?>   
                            </select>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-secondary mt-3 me-2" data-bs-dismiss="modal">CERRAR</button>
                            <button type="submit" class="send-form-button btn btn-primary mt-3" data-bs-dismiss="modal">CONFIRMAR</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal DELETE ARTICLE-->
    <div>
        <div id="deleteArticle" class="modal fade" tabindex="-1" aria-labelledby="deleteArticleLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteArticleLabel">BAJA TRABAJADOR</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="text-center text-muted">Está a punto de dar de baja un trabajador. ¿Está completamente seguro de realizar esta acción?</p>
                </div>
                <!-- Ruta para eliminar un registro -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CERRAR</button>
                    <button type="button" class="delete-table-modal btn btn-primary" data-bs-dismiss="modal" data-route="deleteTrabajador">ELIMINAR</button>
                </div>
            </div>
        </div>
    </div>


    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script type="module" src="dist/main.js"></script>
</body>

</html>