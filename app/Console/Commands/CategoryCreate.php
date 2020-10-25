<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Category;
use Validator;

class CategoryCreate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'category:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create categories from json/categories.json';

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
            $category->createCategories($categories);
            $this->info('Categories from JSON was created!');
        } else 
            $this->info('JSON file is empty!');

        return 0;
    }
}
