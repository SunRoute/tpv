<?php

	namespace app\Controllers;

	require_once 'app/Models/ProductCategory.php';

	use app\Models\ProductCategory;

	class ProductCategoryController {

		protected $productcategory;

		public function __construct(){  

			$this->productcategory = new ProductCategory();
		}

		public function index(){
			return $this->productcategory->index();
		
		}

		public function administracionCategorias(){
			return $this->productcategory->administracionCategorias();
		
		}

		public function store($id, $nombre, $imagen_url ){
			return $this->productcategory->store($id, $nombre, $imagen_url );
		}

		public function show($categoria){
			return $this->productcategory->show($categoria);
		}

		public function delete($id){
			return $this->productcategory->delete($id);
		}
	}

?>



