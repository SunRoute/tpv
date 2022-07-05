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

		public function total($total){
			return $this->ticket->total($total);
		}
		
		public function addProduct($price_id, $table_id){
			return $this->ticket->addProduct($price_id, $table_id);
		}

	}

?>