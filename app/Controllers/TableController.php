<?php

	namespace app\Controllers;

	require_once 'app/Models/Table.php';

	use app\Models\Table;

	class TableController {

		protected $table;

		public function __construct(){  

			$this->table = new Table();
		}

		public function index(){
			return $this->table->index();
		}

		public function numero($mesa){
			return $this->table->numero($mesa);
		}

		public function actualizar($estado, $table_id){
			return $this->table->actualizar($estado, $table_id);
		}
		
		public function store($id, $numero, $ubicacion, $pax){
			return $this->table->store($id, $numero, $ubicacion, $pax);
		}

		public function show($table){
			return $this->table->show($table);
		}

		public function delete($id){
			return $this->table->delete($id);
		}

		public function filtroUbicacion($id){
			return $this->table->filtroUbicacion($id);
		}

		
	}

?>