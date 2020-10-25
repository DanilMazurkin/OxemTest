<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\jsonForConsole;
use App\Traits\validateJson;
use Validator;

class Product extends Model
{ 

  use jsonForConsole, validateJson;

  protected $table = "products";
  public $timestamps = false;

	public $fillable = ['external_id', 'describe', 'name', 'price', 'category_id', 'quantity', 'created_on'];

	protected $casts = [
    'category_id' => 'array',
  ];

  public function categories()
	{
    	return $this->belongsToMany(Category::class);
	}

  public function updateProducts($idProducts, $products) 
  {
    
    $product = new Product;  

    for ($i = 0; $i < count($idProducts); $i++) { 

      $name = $products[$i]['name'];
      $external_id = $products[$i]['external_id'];
      $price = $products[$i]['price'];
      $quantity = $products[$i]['quantity'];


      Product::whereId($idProducts[$i])->update([
          'name' => $name,
          'external_id' => $external_id, 
          'price' => $price,
          'quantity' => $quantity
      ]);

      $categories_id = $products[$i]['category_id'];
      $product->categories()->updateExistingPivot($product, array('category_id' => $categories_id));
    
    }

  }

  public function createProducts($products) 
  {
      
      for ($i = 0; $i < count($products); $i++) {
        $name = $products[$i]['name'];
        $external_id = $products[$i]['external_id'];
        $price = $products[$i]['price'];
        $quantity = $products[$i]['quantity'];

        $product = Product::create([
          'name' => $name,
          'external_id' => $external_id, 
          'price' => $price,
          'quantity' => $quantity
        ]);

        $categoriesId = $products[$i]['category_id'];
        $categories = Category::find($categoriesId);
        $product->categories()->attach($categories);
        $product->save();

      }

  }

}
