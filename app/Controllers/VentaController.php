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

		public function total($fecha){
			return $this->venta->total($fecha);
		}

		public function cobrar($base, $iva, $precio_total, $pago, $table_id){
 
			$ultimo_ticket = $this->venta->ultimo_ticket();
			$numero_ticket = $this->generarTicket($ultimo_ticket['numero_ticket']);

			return $this->venta->cobrar($numero_ticket, $base, $iva, $precio_total, $pago, $table_id);
		}

		public function generarTicket($ultimo_ticket){
        
			$fecha = date("ymd");
			$posTicket = strpos($ultimo_ticket, $fecha);
		
			if($posTicket !== false){
				return $ultimo_ticket + 1;
			}else{
				return $fecha."0001";
			}
		}

		public function ocupacion($venta_id, $creacion_ticket){
			return $this->venta->ocupacion($venta_id, $creacion_ticket);
		}


    }
?>