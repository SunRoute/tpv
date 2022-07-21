<?php

    namespace app\Models;

    require_once 'core/Connection.php';

    use PDO;
    use core\Connection;

    class Iva extends Connection {

	    public function index(){

            $query = "SELECT * FROM iva WHERE activo = 1";

            $stmt = $this->pdo->prepare($query);
            $result = $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }

        public function store($id, $tipo, $vigente){
            
            if(empty($id)){
                $query = "INSERT INTO iva (tipo, vigente, activo, creado, actualizado, multiplicador)
                VALUES ($tipo, $vigente, 1, NOW(), NOW(), 1+($tipo/100))";
                
                $stmt = $this->pdo->prepare($query);
                $result = $stmt->execute();

                $query = "SELECT * FROM iva WHERE id =".$this->pdo->lastInsertId();

            }else{
                $query = "UPDATE iva SET tipo = $tipo, vigente = $vigente, actualizado = NOW(), multiplicador = 1+($tipo/100)
                WHERE id = $id";
    
                $stmt = $this->pdo->prepare($query);
                $result = $stmt->execute();   

                $query = "SELECT * FROM iva WHERE id =".$id;
            }

            $stmt = $this->pdo->prepare($query);
            $result = $stmt->execute();
           
            return $stmt->fetch(PDO::FETCH_ASSOC);

        }

        public function show($iva){

            $query = "SELECT * FROM iva
            WHERE id = $iva AND vigente = 1";

            $stmt = $this->pdo->prepare($query);
            $result = $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function delete($id){

            $query = "UPDATE iva SET activo=0, actualizado = NOW()
            WHERE id = $id";

            $stmt = $this->pdo->prepare($query);
            $result = $stmt->execute();

        } 
    }





