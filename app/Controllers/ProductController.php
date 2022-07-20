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

		public function administracionProductos(){
			return $this->product->administracionProductos();
		}
		
		public function store($id, $nombre, $categoria, $visible, $imagen_url){
			return $this->product->store($id, $nombre, $categoria, $visible, $imagen_url);
		}

		public function show($product){
			return $this->product->show($product);
		}

		public function delete($id){
			return $this->product->delete($id);
		}

		
	}	

?>