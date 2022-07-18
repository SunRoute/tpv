<?php

	namespace app\Controllers;

	require_once 'app/Models/Product.php';

	use app\Models\Product;

	class ProductController {

		protected $product;

		public function __construct(){  

			$this->product = new Product();
		}

		public function index($category){
			return $this->product->index($category);
		}
		public function categoria($category){
			return $this->product->categoria($category);
		}
		
		public function store($id, $nombre){
			return $this->product->store($id, $nombre);
		}

		public function show($product){
			return $this->product->show($product);
		}

		public function delete($id){
			return $this->product->delete($id);
		}

		public function administracion($id){
			return $this->product->administracion($id);
		}
	}	

?>