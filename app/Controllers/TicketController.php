<?php

	namespace app\Controllers;

	require_once 'app/Models/Tickets.php';

	use app\Models\Ticket;

	class TicketController {

		protected $ticket;

		public function __construct(){  

			$this->ticket = new Ticket();
		}

		public function index(){
			return $this->ticket->index();
		}
	}

?>