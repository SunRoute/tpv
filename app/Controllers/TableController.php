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
		
		public function storeTable($id){
			return $this->table->storeTable($id);
		}

		public function showTable($id){
			return $this->table->showTable($id);
		}

		public function deleteTable($id){
			return $this->table->deleteTable($id);
		}
		
	}

?>