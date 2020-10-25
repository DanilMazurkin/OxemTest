<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Validator;

class Product extends Model
{
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

   public function checkHasFromJson() 
   {

        $products_json = file_get_contents(public_path('json/products.json'));
        $products = json_decode($products_json, true);
          

        if (isset($products))
        {
          $this->validateJson($products);
          return $products;
        } else
          return 0;

    } 

  public function updateProducts($idProducts, $products) 
  {
    $product = new Product;  

    for ($i = 0; $i < count($idProducts); $i++)
    { 

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
      $categories = Category::find($categories_id);
      $product->categories()->attach($categories);
    
    }

  }

  public function createProducts($products) {
      
      for ($i = 0; $i < count($products); $i++) 
      {
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

        $categories_id = $products[$i]['category_id'];
        $categories = Category::find($categories_id);
        $product->categories()->attach($categories);
      }

  }

  private function validateJson($products) 
  {


    for ($i = 0; $i < count($products); $i++) 
    {
      
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
}
