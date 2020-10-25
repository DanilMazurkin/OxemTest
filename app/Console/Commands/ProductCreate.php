<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\Product;
use App\Models\Category;
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
        $product = new Product();
        $products = $product->checkHasFromJsonProducts();

        if ($products != 0)
        {
            $product->createProducts($products);
            $this->info('Products from JSON was created!');
        } else 
            $this->info('JSON file is empty!');

        return 0;
    }
}
