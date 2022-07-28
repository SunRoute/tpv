<?php

    namespace app\Models;

    require_once 'core/Connection.php';

    use PDO;
    use core\Connection;

    class Trabajador extends Connection {

	    public function index(){

            $query = "SELECT nombre, apellidos, correo, sucursal_id, sucursales.nombre_comercial AS sucursal, situacion 
            FROM trabajadores
            INNER JOIN sucursales ON trabajadores.sucursal_id = sucursales.id
            WHERE activo = 1";

            $stmt = $this->pdo->prepare($query);
            $result = $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }

        public function store($id, $nombre, $apellidos, $correo, $sucursal_id, $situacion){
            
            if(empty($id)){
                $query = "INSERT INTO trabajadores (nombre, apellidos, correo, sucursal_id, situacion, activo, creado, actualizado)
                VALUES ('$nombre', '$apellidos', '$correo', $sucursal_id, $situacion, 1, NOW(), NOW())";
                
                $stmt = $this->pdo->prepare($query);
                $result = $stmt->execute();

                $query = "SELECT * FROM trabajadores WHERE id =".$this->pdo->lastInsertId();

            }else{
                $query = "UPDATE trabajadores SET nombre = '$nombre', apellidos = '$apellidos', correo = '$correo', sucursal_id = $sucursal_id, situacion = $situacion, actualizado = NOW()
                WHERE id = $id";
    
                $stmt = $this->pdo->prepare($query);
                $result = $stmt->execute();   

                $query = "SELECT * FROM trabajadores WHERE id =".$id;
            }

            $stmt = $this->pdo->prepare($query);
            $result = $stmt->execute();
           
            return $stmt->fetch(PDO::FETCH_ASSOC);

        }

        public function show($trabajador){

            $query = "SELECT * FROM trabajadores
            WHERE id = $trabajador";

            $stmt = $this->pdo->prepare($query);
            $result = $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function delete($id){

            $query = "UPDATE trabajadores SET activo=0, actualizado = NOW()
            WHERE id = $id";

            $stmt = $this->pdo->prepare($query);
            $result = $stmt->execute();

        }

    }

?>    