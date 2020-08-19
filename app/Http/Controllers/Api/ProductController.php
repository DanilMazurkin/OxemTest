<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;
use App\Http\Requests\Api\ProductsFormRequest;

class ProductController extends Controller
{
    public function create(ProductsFormRequest $request) {

    	$external_id = $request->input('external_id');
    	$name = $request->input('name');
    	$describe = $request->input('describe');
    	$price = $request->input('price');
    	$quantity = $request->input('quantity');
    	$category_id = $request->input('category_id');

    	Product::create([
    		'external_id' => $external_id,
    		'name' => $name,
    		'describe' => $describe, 
    		'price' => $price, 
    		'quantity' => $quantity, 
    		'category_id' => $category_id
    	]);


    	return response()->json([
            'message' => 'Product was success create!'
        ], 200);
    }
}
