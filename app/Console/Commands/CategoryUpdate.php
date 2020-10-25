<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Category;
use Validator;

class CategoryUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'category:update {--id=*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update category from json/categories.json';

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

        $category = new Category();
        $categories = $category->checkHasFromJson();

        if ($categories != 0)
        {   
            $idCategories = $this->option('id');

            if (count($idCategories) != count($categories)) 
            {
                $this->info('Need '.count($categories)." id!");
                return 0;
            }

            $category->updateCategories($idCategories, $categories);
            $this->info('Categories from JSON was updated!');
        
        } else 
            $this->info('JSON file is empty!');


        return 0;
    }
}
