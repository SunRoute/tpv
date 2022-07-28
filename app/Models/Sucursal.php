<?php

    namespace app\Models;

    require_once 'core/Connection.php';

    use PDO;
    use core\Connection;

    class Sucursal extends Connection {

	    public function index(){

            $query = "SELECT * FROM sucursales WHERE activo = 1";

            $stmt = $this->pdo->prepare($query);
            $result = $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }

        public function store($id, $nombre_comercial, $domicilio, $codigo_postal, $telefono, $correo_electronico, $web){
            
            if(empty($id)){
                $query = "INSERT INTO sucursales (nombre_comercial, domicilio, codigo_postal, telefono, correo_electronico, web, activo, creado, actualizado)
                VALUES ('$nombre_comercial', '$domicilio', '$codigo_postal', '$telefono', '$correo_electronico', '$web', 1, NOW(), NOW())";
                
                $stmt = $this->pdo->prepare($query);
                $result = $stmt->execute();

                $query = "SELECT * FROM sucursales WHERE id =".$this->pdo->lastInsertId();

            }else{
                $query = "UPDATE sucursales SET nombre_comercial = '$nombre_comercial', domicilio = '$domicilio', codigo_postal = '$codigo_postal', telefono = '$telefono', correo_electronico = '$correo_electronico', web =  '$web', actualizado = NOW()
                WHERE id = $id";
    
                $stmt = $this->pdo->prepare($query);
                $result = $stmt->execute();   

                $query = "SELECT * FROM sucursales WHERE id =".$id;
            }

            $stmt = $this->pdo->prepare($query);
            $result = $stmt->execute();
           
            return $stmt->fetch(PDO::FETCH_ASSOC);

        }

        public function show($sucursal){

            $query = "SELECT * FROM sucursales
            WHERE id = $sucursal";

            $stmt = $this->pdo->prepare($query);
            $result = $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function delete($id){

            $query = "UPDATE sucursales SET activo=0, actualizado = NOW()
            WHERE id = $id";

            $stmt = $this->pdo->prepare($query);
            $result = $stmt->execute();

        }

    }

?>    