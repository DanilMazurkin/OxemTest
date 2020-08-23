<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Validator;
use App\Product;
use App\Category;
use Carbon\Carbon;

class ProductUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'product:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update product';

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
        $products_from_file = json_decode($products_json, true);
        $id_arr = array();

        $products_all = Product::all();
        $categories_all = Category::all();

        foreach ($products_all as $product) 
            $id_arr[] = $product->id;

        if (isset($products_all[0]))
        {
            for ($i = 0; $i < count($products_from_file); $i++)
            {
                    $created_on = Carbon::now();
                    $external_id = $products_from_file[$i]['external_id'];
                    $name = $products_from_file[$i]["name"];
                    $price = $products_from_file[$i]["price"];
                    $quantity = $products_from_file[$i]["quantity"];
                    $category_id = $products_from_file[$i]['category_id'];

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

                    Product::whereId($id_arr[$i])->update(
                        ['name' => $products_from_file[$i]['name']],
                        ['external_id' => $products_from_file[$i]['external_id']],
                        ['price' => $products_from_file[$i]['price']],
                        ['quantity' => $products_from_file[$i]['quantity']],
                        ['category_id' =>  $products_from_file[$i]['category_id']],
                        ['created_on' =>   $created_on]
                    );

                    $categories_belongs = Category::find($categories_current); 
                    $product->categories()->sync($categories_belongs);
            }

            $this->info('Product was update!');
        } else
            $this->info('Nothing update!');


        return 0;
    }
}
