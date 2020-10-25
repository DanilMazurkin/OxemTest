<?php

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ProductsTableSeeder::class);
      	$product = factory(Product::class, 100)->create();
        $this->call(CategoriesTableSeeder::class);
        $categories = factory(Category::class, 10)->create();

		Product::all()->each(function ($product) use ($categories) { 
		     $product->categories()->attach($categories);
		});
    }
}
