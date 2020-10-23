<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\ProductsFormRequest;
use Carbon\Carbon;
use App\Product;
use App\Category;

class ProductController extends Controller
{

	public function index() {

		
		if (empty($_GET['order']) && empty($_GET['field']))
			$products = Product::paginate(50);


		if (!empty($_GET['field']))
		{	
			if ($_GET['field'] == 'price')
				$products = Product::orderBy('price')->paginate(50);
		}
		
		
		if (!empty($_GET['field'])) {
			if ($_GET['field'] == 'created_on')
				$products = Product::orderBy('created_on')->paginate(50);
		}

		
		if (!empty($_GET['order']) && !empty($_GET['field'])) 
		{	
			if ($_GET['order'] == 'desc' && $_GET['field'] == 'price') 
				$products = Product::orderBy('price', 'DESC')->paginate(50);
		}

		if (!empty($_GET['order']) && !empty($_GET['field'])) 
		{
			if ($_GET['order'] == 'desc' && $_GET['field'] == 'created_on')
				$products = Product::orderBy('created_on', 'DESC')->paginate(50);
		}



		return response()->json([
				'products' => $products
		], 200);
		


	}

	public function indexByCategory($id_category) {
		$category = Category::find($id_category);
		$products = $category->products;

		return response()->json([
			'products' => $products 
		], 200);
	}

    public function store(ProductsFormRequest $request) 
    {
    	$now = Carbon::now();
    	$product = Product::create(array_merge(['created_on' => $now], $request->input()));

	    return response()->json([
	    		'id' => $product->id,
	    		'message' => 'Product was created!'
	    ], 201);
    }

    public function show($id) 
    {
    	$product = Product::find($id);

    	return response()->json([
    		'product' => $product
    	], 200);
    }

    public function destroy($id) 
    {
    	$product = Product::find($id);
    	$category = Category::find($id);

    	$product->categories()->detach($category);

    	Product::destroy($id);
    	
    	return response()->json([
    		'message' => "Product was deleted!"
    	], 202);
    }


}
