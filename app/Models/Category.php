<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Validator;

class Category extends Model
{
    protected $table = "categories";
    public $timestamps = false;

	public $fillable = ['name', 'id_parent_category', 'external_id'];

	public function products()
	{
    	return $this->belongsToMany(Product::class);
	}

	public function checkHasFromJson() 
	{

		$categories_json = file_get_contents(public_path('json/categories.json'));
        $categories = json_decode($categories_json, true);
        
        if (isset($categories))
        {
        	$this->validateJson($categories);
        	return $categories;
        } else
        	return 0;
	

	}	

	public function createCategories($categories) 
	{

		for ($i = 0; $i < count($categories); $i++) 
		{
			Category::create($categories[$i]);
		}

	}

	public function updateCategories($idCategories, $categories)
	{


		for ($i = 0; $i < count($idCategories); $i++)
		{
			Category::whereId($idCategories[$i])->update($categories[$i]);
		}

	}

	private function validateJson($categories) 
	{


		for ($i = 0; $i < count($categories); $i++) 
		{
			
			$external_id = $categories[$i]['name'];
			$name = $categories[$i]['external_id'];

			$validator = Validator::make([
                'external_id' => $external_id,
                'name' => $name,

            ], [
              'external_id' => ['required', 'integer'],
              'name' => ['required', 'string','max:255']
            ]);


		}



	}

}
