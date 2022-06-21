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
	}

?>



