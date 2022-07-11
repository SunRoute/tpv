<?php

	namespace app\Controllers;

	require_once 'app/Models/Ticket.php';

	use app\Models\Ticket;

	class TicketController {

		protected $ticket;

		public function __construct(){  

			$this->ticket = new Ticket();
		}

		public function index($mesa){
			return $this->ticket->index($mesa);
		}

		public function total($table_id){
			return $this->ticket->total($table_id);
		}
		
		public function addProduct($price_id, $table_id){
			return $this->ticket->addProduct($price_id, $table_id);
		}

		public function deleteProduct($tickets_id){
			return $this->ticket->deleteProduct($tickets_id);
		}

		public function deleteAll($table_id){
			return $this->ticket->deleteAll($table_id);
		}

		public function formaPago(){
			return $this->ticket->formaPago();
		}

		public function ventaCerrada($table_id, $venta_id){
			return $this->ticket->ventaCerrada($table_id, $venta_id);
		}


	}

?>