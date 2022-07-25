<?php

	namespace app\Controllers;

	require_once 'app/Models/Product.php';
	require_once 'app/Services/ExcelService.php';

	use app\Models\Product;
	use app\Services\ExcelService;

	class ProductController {

		protected $product;

		public function __construct(){  

			$this->product = new Product();
		}

		public function index(){
			return $this->product->index();
		}	

		public function indexPorCategoria($category){
			return $this->product->indexPorCategoria($category);
		}
		
		public function categoria($category){
			return $this->product->categoria($category);
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

		public function exportProductToExcel(){

			$excel_service = new ExcelService();
	
			$productos = $this->product->index();
			
			$excel_service->exportProductToExcel($productos);
		}


		
	}	

?>