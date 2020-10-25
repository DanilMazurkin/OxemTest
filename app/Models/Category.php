<?php

namespace App\Models;

use App\Traits\jsonForConsole;
use App\Traits\validateJson;
use Illuminate\Database\Eloquent\Model;
use Validator;

class Category extends Model
{
	use jsonForConsole, validateJson;

    protected $table = "categories";
    public $timestamps = false;

	public $fillable = ['name', 'id_parent_category', 'external_id'];

	public function products()
	{
    	return $this->belongsToMany(Product::class);
	}


	public function createCategories($categories) 
	{

		for ($i = 0; $i < count($categories); $i++) 
			Category::create($categories[$i]);

	}

	public function updateCategories($idCategories, $categories)
	{

		for ($i = 0; $i < count($idCategories); $i++)
			Category::whereId($idCategories[$i])->update($categories[$i]);
	
	}

}
