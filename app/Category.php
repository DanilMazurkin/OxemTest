<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = "categories";
    public $timestamps = false;

	public $fillable = ['name', 'id_parent_category', 'external_id'];

	public function products()
	{
    	return $this->belongsToMany(Product::class);
	}

}
