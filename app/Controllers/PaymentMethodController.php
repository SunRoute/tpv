<?php

	namespace app\Controllers;

	require_once 'app/Models/PaymentMethod.php';

	use app\Models\PaymentMethod;

	class PaymentMethodController {

		protected $pago;

		public function __construct(){  

			$this->pago = new PaymentMethod();
		}

        public function index(){
			return $this->pago->index();
		}

		public function formaPago(){
			return $this->pago->formaPago();
		}

		public function store($id, $nombre){
			return $this->pago->store($id, $nombre);
		}

		public function show($pago){
			return $this->pago->show($pago);
		}

		public function delete($id){
			return $this->pago->delete($id);
		}
    }    