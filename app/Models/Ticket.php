<?php

    namespace app\Models;

    require_once 'core/Connection.php';

    use PDO;
    use core\Connection;

    class Ticket extends Connection {

	    public function index(){

            $query = "SELECT productos.nombre AS Producto, precios.precio_base, productos_categorias.nombre AS Categoría, productos.imagen_url AS Imagen FROM tickets INNER JOIN precios ON tickets.precio_id = precios.id INNER JOIN productos ON precios.producto_id = productos.id INNER JOIN productos_categorias ON productos.categoria_id = productos_categorias.id WHERE mesa_id = 4 AND tickets.activo = 1 AND venta_id IS NULL";

            $stmt = $this->pdo->prepare($query);
            $result = $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }
    }

?>