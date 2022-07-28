<?php

	namespace app\Controllers;

	require_once 'app/Models/Empresa.php';

	use app\Models\Empresa;

	class EmpresaController {

		protected $empresa;

		public function __construct(){  

			$this->empresa = new Empresa();
		}

		public function index(){
			return $this->empresa->index();
		}

        public function store($id, $razon_social, $nombre_comercial, $cif, $domicilio, $telefono, $correo_electronico, $web){
			return $this->empresa->store($id, $razon_social, $nombre_comercial, $cif, $domicilio, $telefono, $correo_electronico, $web);
		}

		public function show($empresa){
			return $this->empresa->show($empresa);
		}

		public function delete($id){
			return $this->empresa->delete($id);
		}
    
	}

?>        