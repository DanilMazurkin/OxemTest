<?php

namespace App\Traits;
use Validator;


trait validateJson {
	private function validateJsonProducts($products) 
    {


      for ($i = 0; $i < count($products); $i++) {
        
        $external_id = $products[$i]['external_id'];
        $name = $products[$i]['name'];
        $price = $products[$i]['price'];
        $quantity = $products[$i]['quantity'];
        $category_id = $products[$i]['category_id'];

        $validator = Validator::make([
                  'external_id' => $external_id,
                  'name' => $name,
                  'price' => $price,
                  'quantity' => $quantity,
                  'category_id' => $category_id
              ], [
                'external_id' => ['required', 'integer'],
                'name' => ['required', 'string','max:255'],
                'price' => ['required', 'float'],
                'quantity' => ['required', 'integer'],
                'category_id' => ['required', 'array']
        ]);

      }
    }

    private function validateJsonCategories($categories) 
	{


		for ($i = 0; $i < count($categories); $i++) {
			
			$external_id = $categories[$i]['name'];
			$name = $categories[$i]['external_id'];

			$validator = Validator::make([
                'external_id' => $external_id,
                'name' => $name,

            ], [
              'external_id' => ['required', 'integer'],
              'name' => ['required', 'string','max:255']
            ]);


		}



	}

}