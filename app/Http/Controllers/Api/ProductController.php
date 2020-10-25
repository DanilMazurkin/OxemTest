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


		if (!empty($request->get('sort'))) {	
			if ($request->get('sort') == 'price')
				$products = Product::orderBy('price')->paginate(50);
		}
		
		
		if (!empty($request->get('sort'))) {
			if ($request->get('sort') == 'created_on')
				$products = Product::orderBy('created_on')->paginate(50);
		}

		
		if (!empty($request->get('order')) && !empty($request->get('sort'))) {	
			if ($request->get('order') == 'desc' && $request->get('sort') == 'price') 
				$products = Product::orderBy('price', 'DESC')->paginate(50);
		}

		if (!empty($request->get('order')) && !empty($request->get('sort'))) {
			if ($request->get('order') == 'desc' && $request->get('sort') == 'created_on')
				$products = Product::orderBy('created_on', 'DESC')->paginate(50);
		}



		return response()->json([
				'products' => $products
		], 200);
		


	}

	public function indexByCategory(Category $category)
	{
		
		$products = $category->products;


		if (isset($products[0]))
			return response()->json([
				'products' => $products 
			], 200);
		else
			return response()->json([
				'message' => 'Not found!'
			], 404);

	
	}

    public function store(ProductsFormRequest $request) 
    {
    	$product = Product::create(array_merge(['created_on' => Carbon::now()], $request->input()));

	    return response()->json([
	    		'message' => 'Product was created!'
	    ], 201);
    }

    public function show(Product $product) 
    {
	    	
	    	return response()->json([
    			'product' => $product
    		], 200);

    }

    public function destroy(Product $product) 
    {

    	$categoryRelation = $product->categories;
    	$categoriesId = array();

    	for ($i = 0; $i < count($categoryRelation); $i++)
    		$categoriesId[] = $categoryRelation[$i]['id'];

    	$product->categories()->detach($categoriesId);

    	$product->delete();
    	
    	return response()->json([
    		'message' => "Product was deleted!"
    	], 202);
    }


}
