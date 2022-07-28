<?php

    namespace app\Models;

    require_once 'core/Connection.php';

    use PDO;
    use core\Connection;

    class Empresa extends Connection {

	    public function index(){

            $query = "SELECT * FROM empresas WHERE activo = 1";

            $stmt = $this->pdo->prepare($query);
            $result = $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }

        public function store($id, $razon_social, $nombre_comercial, $cif, $domicilio, $telefono, $correo_electronico, $web){
            
            if(empty($id)){
                $query = "INSERT INTO empresas (razon_social, nombre_comercial, cif, domicilio, telefono, correo_electronico, web, activo, creado, actualizado)
                VALUES ('$razon_social', '$nombre_comercial', '$cif', '$domicilio', '$telefono', '$correo_electronico', '$web', 1, NOW(), NOW())";
                
                $stmt = $this->pdo->prepare($query);
                $result = $stmt->execute();

                $query = "SELECT * FROM empresas WHERE id =".$this->pdo->lastInsertId();

            }else{
                $query = "UPDATE empresas SET razon_social = '$razon_social', nombre_comercial = '$nombre_comercial', cif = '$cif', domicilio = '$domicilio', telefono = '$telefono', correo_electronico = '$correo_electronico', web =  '$web', actualizado = NOW()
                WHERE id = $id";
    
                $stmt = $this->pdo->prepare($query);
                $result = $stmt->execute();   

                $query = "SELECT * FROM empresas WHERE id =".$id;
            }

            $stmt = $this->pdo->prepare($query);
            $result = $stmt->execute();
           
            return $stmt->fetch(PDO::FETCH_ASSOC);

        }

        public function show($empresa){

            $query = "SELECT * FROM empresas
            WHERE id = $empresa";

            $stmt = $this->pdo->prepare($query);
            $result = $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function delete($id){

            $query = "UPDATE empresas SET activo=0, actualizado = NOW()
            WHERE id = $id";

            $stmt = $this->pdo->prepare($query);
            $result = $stmt->execute();

        }

    }

?>    