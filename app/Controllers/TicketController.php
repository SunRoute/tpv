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

		public function total($mesa){
			return $this->ticket->total($mesa);
		}
		
		public function numero($mesa){
			return $this->ticket->numero($mesa);
		}
		
	}

?>