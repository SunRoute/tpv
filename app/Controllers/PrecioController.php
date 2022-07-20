<?php

	namespace app\Controllers;

	require_once 'app/Models/Precio.php';

	use app\Models\Precio;

	class PrecioController {

		protected $precio;

		public function __construct(){  

			$this->precio = new Precio();
            
		}

        public function store($new_product_id, $iva, $base){

			$resultado = $this->precio->filtrarPrecios($new_product_id, $iva, $base);

			if(empty($resultado)){

				return $this->precio->store($new_product_id, $iva, $base);
			
			}
		}
		
        public function delete($id){
			return $this->precio->delete($id);
		}

    }
?>  