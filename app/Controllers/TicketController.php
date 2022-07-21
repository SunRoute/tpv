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

		public function addFakeProduct($price_id, $table_id, $timestamp){
			return $this->ticket->addFakeProduct($price_id, $table_id, $timestamp);
		}

		public function deleteProduct($tickets_id){
			return $this->ticket->deleteProduct($tickets_id);
		}

		public function deleteAll($table_id){
			return $this->ticket->deleteAll($table_id);
		}

		public function ultimoTicketCreado($venta_id){
			return $this->ticket->ultimoTicketCreado($venta_id);
		}

		public function ventaCerrada($table_id, $venta_id){
			return $this->ticket->ventaCerrada($table_id, $venta_id);
		}

		public function ventaFakeCerrada($table_id, $venta_id, $timestamp){
			return $this->ticket->ventaFakeCerrada($table_id, $venta_id, $timestamp);
		}
	}

?>