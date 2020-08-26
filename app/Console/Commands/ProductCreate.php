<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Product;
use App\Category;
use Validator;

class ProductCreate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'product:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create product';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $products_json = file_get_contents(public_path('products.json'));
        $products = json_decode($products_json, true);
        $categories_json = file_get_contents(public_path('categories.json'));
        $categories = json_decode($categories_json, true);

        if (empty($products) || empty($categories)) {
            $this->info("Products.json or categories.json is empty");
            return 0;
        }

        $categories_all = Category::all();
        $products_all = Product::all();

        if (count($categories_all) == 0) {
            $this->info('First create categories');
            return 0;
        }

        if (isset($categories_all[0]) && count($products_all) == 0) {
                
                for ($i = 0; $i < count($products); $i++) {
                   
                    $created_on = Carbon::now();
                    $external_id = $products[$i]['external_id'];
                    $name = $products[$i]["name"];
                    $price = $products[$i]["price"];
                    $quantity = $products[$i]["quantity"];
                    $category_id = $products[$i]['category_id'];

                    $categories_current = $categories_all[$i]->id;


                    $validator = Validator::make([
                        'external_id' => $external_id,
                        'name' => $name,
                        'price' => $price,
                        'category_id' => $category_id, 
                        'quantity' => $quantity
                    ], [
                      'external_id' => ['required', 'integer'],
                       'name' => ['required', 'string','max:255'],
                       'describe' => ['required', 'string','max:1000'],
                       'price' => ['required', 'numeric'],
                       'quantity' => ['required', 'integer'],
                       'category_id' => ['required', 'json']
                    ]);

                    $product = Product::create([
                        'external_id' => $external_id,
                        'created_on' => $created_on,
                        'name' => $name,
                        'price' => $price, 
                        'quantity' => $quantity, 
                        'category_id' => $category_id
                    ]); 

                    $categories_belongs = Category::find($categories_current); 
                    $product->categories()->attach($categories_belongs);
                }

                $this->info("Create products!");
        } else 
            $this->info("First clear products table");
        



        return 0;
    }
}
