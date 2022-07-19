<?php

	namespace app\Controllers;

	require_once 'app/Models/Precio.php';

	use app\Models\Precio;

	class PrecioController {

		protected $precio;

		public function __construct(){  

			$this->precio = new Precio();
            
		}

        public function store(){
			return $this->precio->store();
		}

        public function delete(){
			return $this->precio->delete();
		}

    }
?>  