<?php

    namespace app\Models;

    require_once 'core/Connection.php';

    use PDO;
    use core\Connection;

    class Table extends Connection {

	    public function index(){

            $query = "SELECT * FROM mesas WHERE activo = 1";

            $stmt = $this->pdo->prepare($query);
            $result = $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }

        public function numero($mesa){

            $query = "SELECT
            mesas.numero AS numero
            FROM mesas
            WHERE mesas.id = $mesa";

            $stmt = $this->pdo->prepare($query);
            $result = $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);

        }

        public function actualizar($estado, $table_id){

            $query = "UPDATE mesas SET estado = $estado, actualizado = NOW() WHERE id = $table_id ";

            $stmt = $this->pdo->prepare($query);
            $result = $stmt->execute();

            return "ok";

        }

    }

?>