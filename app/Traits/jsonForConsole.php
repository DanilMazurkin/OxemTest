<?php

namespace App\Traits;

use App\Models\Product;
use App\Models\Category;

trait jsonForConsole {

   public function checkHasFromJsonProducts() 
   {

        $products_json = file_get_contents(public_path('json/products.json'));
        $products = json_decode($products_json, true);
         
        $product = new Product();

        if (isset($products))
        {
          $product->validateJson($products);
          return $products;
        } else
          return 0;

    } 

    public function checkHasFromJsonCategories() 
	{

		$categories_json = file_get_contents(public_path('json/categories.json'));
        $categories = json_decode($categories_json, true);
        
        $category = new Category();

        if (isset($categories))
        {
        	$category->validateJson($categories);
        	return $categories;
        } else
        	return 0;
	

	}	

}