<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Product;
use App\Category;
use DB;
use App\Http\Requests\Api\ProductsFormRequest;

class ProductController extends Controller
{   

    public function index() {

        $product = Product::paginate(50);

        if (isset($product))
            return response()->json([
                'success' => true,
                'payload' => $product
            ], 200);
        else 
            return response()->json([
                'success' => false,
                'error' => 'No products!'
            ], 401);

    }



    public function create(ProductsFormRequest $request) {

    	$external_id = $request->input('external_id');
    	$name = $request->input('name');
    	$describe = $request->input('describe');
    	$price = $request->input('price');
    	$quantity = $request->input('quantity');
    	$category_id = $request->input('category_id');
        $created_on = Carbon::now();

    	$product = Product::create([
    		'external_id' => $external_id,
            'created_on' => $created_on,
    		'name' => $name,
    		'describe' => $describe, 
    		'price' => $price, 
    		'quantity' => $quantity, 
    		'category_id' => $category_id
    	]); 


        $category_id = json_decode($category_id);
        $categories = Category::find($category_id); 
        $product->categories()->attach($categories);
    	
        if (isset($product))
            return response()->json([
                'success' => true,
                'payload' => $product
            ], 200);
        else 
            return response()->json([
                'success' => false,
                'error' => "Not create product!"
            ], 401);
    }

    public function show($id) {
        $product = Product::find($id);

        if (isset($product))
            return response()->json([
                'success' => true,
                'payload' => $product
            ], 200);
        else
            return response()->json([
                'success' => true,
                'error' => "Not find!"
            ], 401);

    }

    public function showByCategory($id_category){
        
        $id_products = DB::table('category_product')->select('product_id')->where('category_id', '=', $id_category)->get();
            
        if (isset($id_products[0])) {
                $products = array();

                
                for ($i = 0; $i < count($id_products); $i++) {
                      $index = $id_products[0]->product_id;
                      $products[] = Product::find($index);
                }

                return response()->json([
                    'success' => true,
                    'payload' => $products
                ], 200);
        } else
             return response()->json([
                    'success' => false,
                    'message' => 'No products in category!'
              ], 401);
    }   

    public function showByPrice($parametr) {
        


        if ($parametr === "maxmin")  {   

            $products = Product::orderBy('price', 'DESC')->get();


            return response()->json([
                'success' => true, 
                'parametr' => $parametr, 
                'products' => $products
            ]);
        } elseif ($parametr == "minmax") {   

            $products = Product::orderBy('price')->get();


            return response()->json([
                'success' => true, 
                'parametr' => $parametr, 
                'products' => $products
            ]);
        }

    }


    public function showByDate($parametr) {

        if ($parametr == "maxmin") {
            $products = Product::orderBy('created_on', 'DESC')->get();

            return response()->json([
                'success' => true, 
                'parametr' => $parametr, 
                'products' => $products
            ]);

        } elseif ($parametr == "minmax") {
            $products = Product::orderBy('created_on')->get();


            return response()->json([
                'success' => true, 
                'parametr' => $parametr, 
                'products' => $products
            ]);
        }

    }


    public function destroy($id) {

        $product = Product::find($id);
        $product->categories()->detach($product);


        if (isset($product)) {
            Product::destroy($id);

            return response()->json([
                'success' => true,
                'message' => 'You were successfully delete product!'
            ], 200);
        } else 
            return response()->json([
                'success' => false,
                'message' => 'No product with id'
            ], 401);
    }


}
