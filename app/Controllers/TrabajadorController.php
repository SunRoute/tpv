<?php

	namespace app\Controllers;

	require_once 'app/Models/Trabajador.php';

	use app\Models\Trabajador;

	class TrabajadorController {

		protected $trabajador;

		public function __construct(){  

			$this->trabajador= new Trabajador();
		}

		public function index(){
			return $this->trabajador->index();
		}

        public function store($id, $nombre, $apellidos, $correo, $sucursal_id, $situacion){
			return $this->trabajador->store($id, $nombre, $apellidos, $correo, $sucursal_id, $situacion);
		}

		public function show($trabajador){
			return $this->trabajador->show($trabajador);
		}

		public function delete($id){
			return $this->trabajador->delete($id);
		}
    
	}

?>        