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
    protected $signature = 'product:update {--id=*}';

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
        $product = new Product;
        $products = $product->checkHasFromJson();

        if ($products != 0)
        {   
            $idProducts = $this->option('id');

            if (count($idProducts) != count($products)) 
            {
                $this->info('Need '.count($products)." id!");
                return 0;
            }

            $product->updateProducts($idProducts, $products);
            $this->info('Products from JSON was updated!');
        
        } else 
            $this->info('JSON file is empty!');



        return 0;
    }
}
