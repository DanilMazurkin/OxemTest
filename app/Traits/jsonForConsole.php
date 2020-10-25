<?php

namespace App\Traits;

use App\Models\Product;
use App\Models\Category;

trait jsonForConsole {

   public function checkHasFromJsonProducts() 
   {

        $products_json = file_get_contents(public_path('json/products.json'));
        $products = json_decode($products_json, true);
          
        if (isset($products)) {
          $this->validateJsonProducts($products);
          return $products;
        } else
          return 0;

    } 

    public function checkHasFromJsonCategories() 
	  {

	     	$categories_json = file_get_contents(public_path('json/categories.json'));
        $categories = json_decode($categories_json, true);
        

        if (isset($categories)) {
        	$this->validateJsonCategories($categories);
        	return $categories;
        } else
        	return 0;
	

	  }	


}