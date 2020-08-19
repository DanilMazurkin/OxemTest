<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = "products";
    public $timestamps = false;

	public $fillable = ['external_id', 'describe', 'name', 'price', 'category_id', 'quantity'];

	protected $casts = [
    'category_id' => 'array',
  	];

  	public function categories()
	{
    	return $this->belongsToMany(Category::class);
	}
}
