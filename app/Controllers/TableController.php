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
		
	}

?>