<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Category;
use Validator;

class CategoryUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'category:update ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update category';

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
        $categories_from_file = json_decode($categories_json, true);
        $id_arr = array();
        $categories = Category::all();

        foreach ($categories as $category) 
            $id_arr[] = $category->id;


        if (isset($category)) 
        {   
            for ($i = 0; $i < count($categories_from_file); $i++) {

                    $name = $categories_from_file[$i]['name'];                
                    $external_id = $categories_from_file[$i]['external_id'];

                    $validator = Validator::make([
                                'external_id' => $external_id,
                                'name' => $name
                            ], [
                              'external_id' => ['required', 'integer'],
                               'name' => ['required', 'string','max:255']
                    ]);

                    $category = Category::whereId($id_arr[$i])->update(
                        ['name' => $name],
                        ['external_id' => $external_id]
                    );
            }
                
            $this->info("Category was update!");

        } else
            $this->info('Nothing update!');
        



        return 0;
    }
}
