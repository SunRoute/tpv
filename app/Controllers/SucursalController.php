<?php

	namespace app\Controllers;

	require_once 'app/Models/Sucursal.php';

	use app\Models\Sucursal;

	class SucursalController {

		protected $sucursal;

		public function __construct(){  

			$this->sucursal= new Sucursal();
		}

		public function index(){
			return $this->sucursal->index();
		}

        public function store($id, $nombre_comercial, $domicilio, $codigo_postal, $telefono, $correo_electronico, $web){
			return $this->sucursal->store($id, $nombre_comercial, $domicilio, $codigo_postal, $telefono, $correo_electronico, $web);
		}

		public function show($sucursal){
			return $this->sucursal->show($sucursal);
		}

		public function delete($id){
			return $this->sucursal->delete($id);
		}
    
	}

?>        