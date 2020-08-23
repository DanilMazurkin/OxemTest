<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Category;
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
    protected $description = 'Create category';

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

        $categories_json = file_get_contents(public_path('categories.json'));
        $categories = json_decode($categories_json, true);

        for ($i = 0; $i < count($categories); $i++) {
            $name = $categories[$i]['name'];
            $external_id = $categories[$i]['external_id'];


            $validator = Validator::make([
                'external_id' => $external_id,
                'name' => $name,

            ], [
              'external_id' => ['required', 'integer'],
              'name' => ['required', 'string','max:255']
            ]);

            Category::create([
                'name' => $name,
                'external_id' => $external_id
            ]);

        }

        $this->info('Categories from categories.json was create!');

        return 0;
    }
}
