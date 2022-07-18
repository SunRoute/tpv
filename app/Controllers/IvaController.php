<?php

	namespace app\Controllers;

	require_once 'app/Models/Iva.php';

	use app\Models\Iva;

	class IvaController {

		protected $iva;

		public function __construct(){  

			$this->iva = new Iva();
		}

		public function index(){
			return $this->iva->index();
		}

        public function store($id, $tipo, $vigente){
			return $this->iva->store($id, $tipo, $vigente);
		}

		public function show($iva){
			return $this->iva->show($iva);
		}

		public function delete($id){
			return $this->iva->delete($id);
		}
    

	}

?>        