<?php

	namespace app\Controllers;

	require_once 'app/Models/Venta.php';

	use app\Models\Venta;

	class VentaController {

		protected $venta;

		public function __construct(){  

			$this->venta = new Venta();
		}

		public function index(){
			return $this->venta->index();
		}

        public function detalle($venta){
			return $this->venta->detalle($venta);
		}
		
		public function pedido($venta){
			return $this->venta->pedido($venta);
		}
		
		public function filtro($fecha,$mesa){
			return $this->venta->filtro($fecha,$mesa);
		}
    }
?>