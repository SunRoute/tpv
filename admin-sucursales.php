<?php

	require_once 'app/Controllers/SucursalController.php';

	use app\Controllers\SucursalController;

	$sucursal = new SucursalController();
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
                <h1 class="text-center mt-3 border titular"><small class="small-admin">PANEL DE ADMINISTRACIÓN</small>SUCURSALES</h1>
            </div>
            <div class="col-12 mt-5">
                <section>
                    <div class="row">
                        <div class="col d-flex justify-content-end">
                            <button type="button" class="create-form-button btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#addArticle">+ Añadir sucursal</button>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                    <th scope="col">Nombre comercial</th>
                                    <th scope="col">Domicilio</th>
                                    <th scope="col">Código postal</th>
                                    <th scope="col">Teléfono</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Web</th>
                                    <th scope="col">Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($sucursales as $sucursal): ?>
                                        <tr class="table-element" data-element="<?= $sucursal['id'] ?>">
                                            <th scope="row" class="nombre_comercial">
                                                <?= $sucursal['nombre_comercial'] ?>
                                            </th>
                                            <td class="domicilio">
                                                <?= $sucursal['domicilio'] ?>
                                            </td>
                                            <td class="codigo_postal">
                                                <?= $sucursal['codigo_postal'] ?>
                                            </td>
                                            <td class="telefono">
                                                <?= $sucursal['telefono'] ?>
                                            </td>
                                            <td class="correo_electronico">
                                                <?= $sucursal['correo_electronico'] ?>
                                            </td>
                                            <td class="web">
                                                <?= $sucursal['web'] ?>
                                            </td>
                                            <!-- Ruta para mostrar y modificar un registro -->
                                            <td class="opciones">
                                                <button type="button" class="edit-table-button btn btn-success" data-bs-toggle="modal" data-id="<?= $sucursal['id'] ?>" data-route="showSucursal" data-bs-target="#addArticle">
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                                <button type="button" class="delete-table-button btn btn-danger" data-id="<?= $sucursal['id'] ?>" data-bs-toggle="modal" data-bs-target="#deleteArticle">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    <!-- Este dato es invisible mediante d-none. Cada cajita tiene la misma clase que los inputs de la tabla. Clona en admin-form... Mientras exista la plantilla que tenga las mismas clases, se aplicarán los datos-->
                                    <tr class="create-layout table-element d-none" data-element="">
                                        <th scope="row" class="nombre_comercial"></th>
                                        <td class="domicilio"></td>
                                        <td class="codigo_postal"></td>
                                        <td class="telefono"></td>
                                        <td class="correo_electronico"></td>
                                        <td class="web"></td>
                                        <td class="opciones">
                                            <button type="button" class="edit-table-button btn btn-success" data-bs-toggle="modal" data-id="" data-route="showSucursal" data-bs-target="#addArticle">
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
                    <h5 class="modal-title" id="addArticleLabel">ADMINISTRAR SUCURSAL</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Ruta para crear registro nuevo. Se dirige a su caso de web.php -->
                    <form class="admin-form" data-route="storeSucursal">
                        <input type="hidden" name="id" value="">
                        <div class="mb-3">
                            <label for="nombre_comercial" class="form-label">Nombre comercial</label>
                            <input type="text" class="form-control" name="nombre_comercial" value="">
                        </div>
                        <div class="mb-3">
                            <label for="domicilio" class="form-label">Domicilio</label>
                            <input type="text" class="form-control" name="domicilio" value="">
                        </div>
                        <div class="mb-3">
                            <label for="codigo_postal" class="form-label">CIF</label>
                            <input type="text" class="form-control" name="codigo_postal" value="">
                        </div>
                        <div class="mb-3">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="text" class="form-control" name="telefono" value="">
                        </div>
                        <div class="mb-3">
                            <label for="correo_electronico" class="form-label">Email</label>
                            <input type="text" class="form-control" name="correo_electronico" value="">
                        </div>
                        <div class="mb-3">
                            <label for="web" class="form-label">Web</label>
                            <input type="text" class="form-control" name="web" value="">
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
                    <h5 class="modal-title" id="deleteArticleLabel">ELIMINAR SUCURSAL</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="text-center text-muted">Está a punto de borrar una sucursal. ¿Está completamente seguro de realizar esta acción?</p>
                </div>
                <!-- Ruta para eliminar un registro -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CERRAR</button>
                    <button type="button" class="delete-table-modal btn btn-primary" data-bs-dismiss="modal" data-route="deleteSucursal">ELIMINAR</button>
                </div>
            </div>
        </div>
    </div>


    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script type="module" src="dist/main.js"></script>
</body>

</html>