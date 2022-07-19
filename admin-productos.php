<?php

	require_once 'app/Controllers/ProductController.php';
    require_once 'app/Controllers/ProductCategoryController.php';
    require_once 'app/Controllers/IvaController.php';

    use app\Controllers\ProductController;
    use app\Controllers\ProductCategoryController;
    use app\Controllers\IvaController;

	$product = new ProductController();
    $categoria = new ProductCategoryController();
    $iva = new IvaController();

	$products = $product->administracionProductos();
    $categorias = $categoria->administracionCategorias();
    $ivas = $iva->index();
	
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
                <h1 class="text-center mt-3 border titular"><small class="small-admin">PANEL DE ADMINISTRACIÓN</small>PRODUCTOS</h1>
            </div>
            <div class="col-12 mt-5">
                <section>
                    <div class="row">
                        <div class="col d-flex justify-content-end">
                            <button type="button" class="create-form-button btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#addArticle">+ Añadir producto</button>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                    <th scope="col">Imagen</th>    
                                    <th scope="col">Producto</th>
                                    <th scope="col">Categoría</th>
                                    <th scope="col">Visible</th>
                                    <th scope="col">IVA</th>
                                    <th scope="col">Precio base</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($products as $product): ?>
                                        <tr class="table-element" data-element="<?= $product['id'] ?>">
                                            <th scope="row" class="imagen">
                                                <img style="width:5rem;" src="<?= $product['imagen'] ?>" alt="">
                                            </th>
                                            <td class="nombre">
                                                <?= $product['nombre'] ?>
                                            </td>
                                            <td class="categoria">
                                                <?= $product['categoria'] ?>
                                            </td>
                                            <td class="visible">
                                                <?= $product['visible'] ?>
                                            </td>
                                            <td class="iva">
                                                <?= $product['iva'] ?>
                                            </td>
                                            <td class="base">
                                                <?= $product['base'] ?>
                                            </td>
                                            <!-- Ruta para mostrar y modificar un registro -->
                                            <td class="opciones">
                                                <button type="button" class="edit-table-button btn btn-success" data-bs-toggle="modal" data-id="<?= $product['id'] ?>" data-route="showProduct" data-bs-target="#addArticle">
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                                <button type="button" class="delete-table-button btn btn-danger" data-id="<?= $product['id'] ?>" data-bs-toggle="modal" data-bs-target="#deleteArticle">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    <!-- Este dato es invisible mediante d-none. Cada cajita tiene la misma clase que los inputs de la tabla. Clona en admin-form... Mientras exista la plantilla que tenga las mismas clases, se aplicarán los datos-->
                                    <tr class="create-layout table-element d-none" data-element="">
                                        <th scope="row" class="imagen"></th>
                                        <td class="nombre"></td>
                                        <td class="categoria"></td>
                                        <td class="visible"></td>
                                        <td class="iva"></td>
                                        <td class="base"></td>
                                        <td class="opciones">
                                            <button type="button" class="edit-table-button btn btn-success" data-bs-toggle="modal" data-id="" data-route="showProduct" data-bs-target="#addArticle">
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
                    <h5 class="modal-title" id="addArticleLabel">AÑADIR PRODUCTO</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Ruta para crear registro nuevo. Se dirige a su caso de web.php -->
                    <form class="admin-form" data-route="storeProduct">
                        <input type="hidden" name="id" value="">
                        <div class="mb-3">
                            <label for="imagen" class="form-label">Imagen del producto</label>
                            <input type="text" class="form-control" name="imagen" value="">
                        </div>
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre del producto</label>
                            <input type="text" class="form-control" name="nombre" value="">
                        </div>
                        <div class="mb-3">
                            <label for="categoria" class="form-label">Categoría</label>
                            <select class="form-select" aria-label="Default select example" name="categoria">
                                <option selected>Selecciona categoría</option>
                                <?php foreach($categorias as $categoria):?>
                                    <option value="<?= $categoria['id']; ?>"
                                    <?= $categoria['nombre'] == $categoria ? 'selected':'' ?>><?= $categoria['nombre']; ?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="visible" class="form-label">Visible</label>
                            <select class="form-select" aria-label="Default select example" name="visible">
                                <option selected value="1">Sí</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="iva" class="form-label"></label>
                            <select class="form-select" aria-label="Default select example" name="iva">
                                <option selected>Selecciona el IVA</option>
                                <?php foreach($ivas as $iva):?>
                                    <option value="<?= $iva['id']; ?>"
                                    <?= $iva['tipo'] == $iva ? 'selected':'' ?>><?= $iva['tipo']; ?></option>
                                <?php endforeach;?>   
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="base" class="form-label">Precio base</label>
                            <input type="number" class="form-control" name="base" value="">
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
                    <h5 class="modal-title" id="deleteArticleLabel">ELIMINAR PRODUCTO</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="text-center text-muted">Está a punto de borrar un producto. ¿Está completamente seguro de realizar esta acción?</p>
                </div>
                <!-- Ruta para eliminar un registro -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CERRAR</button>
                    <button type="button" class="delete-table-modal btn btn-primary" data-bs-dismiss="modal" data-route="deleteProduct">ELIMINAR</button>
                </div>
            </div>
        </div>
    </div>


    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script type="module" src="dist/main.js"></script>
</body>

</html>