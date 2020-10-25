<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\ProductsFormRequest;
use Carbon\Carbon;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{

	public function index(Request $request) {


		if (empty($request->get('order')) && empty($request->get('sort')))
			$products = Product::paginate(50);


		if (!empty($request->get('sort')))
		{	
			if ($request->get('sort') == 'price')
				$products = Product::orderBy('price')->paginate(50);
		}
		
		
		if (!empty($request->get('sort')))
		{
			if ($request->get('sort') == 'created_on')
				$products = Product::orderBy('created_on')->paginate(50);
		}

		
		if (!empty($request->get('order')) && !empty($request->get('sort'))) 
		{	
			if ($request->get('order') == 'desc' && $request->get('sort') == 'price') 
				$products = Product::orderBy('price', 'DESC')->paginate(50);
		}

		if (!empty($request->get('order')) && !empty($request->get('sort'))) 
		{
			if ($request->get('order') == 'desc' && $request->get('sort') == 'created_on')
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
    	$product = Product::create(array_merge(['created_on' => Carbon::now()], $request->input()));

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
