<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\CategoryFormRequest;
use App\Category;

class CategoryController extends Controller
{
    
    public function index()
    {
        $categories = Category::all();

        return response()->json([
            'success' => true,
            $categories
        ], 200);
    }

    
    public function store(CategoryFormRequest $request)
    {
        $name = $request->input('name');
        $external_id = $request->input('external_id');


        Category::create([
            'name' => $name,
            'external_id' => $external_id,

        ]);
       
        return response()->json([
            'success' => true,
            'message' => 'You were successfully create category!'
        ], 200);
    }


    public function update(CategoryFormRequest $request, $id)
    {
        $name = $request->input('name');
        $external_id = $request->input('external_id');

        $category = Category::find($id);

        if (isset($category)) {
            Category::where('id', $id)->update([
                'name' => $name,
                'external_id' => $external_id
            ]);

            return response()->json([
                'success' => true,
                'message' => 'You were successfully update category!'
            ], 200);
        } else 
            return response()->json([
                'success' => false,
                'message' => 'No category with id'
            ], 401);

    }

    public function destroy($id)
    {   

        $category = Category::find($id);

        if (isset($category)) {
            Category::destroy($id);

            return response()->json([
                'success' => true,
                'message' => 'You were successfully delete category!'
            ], 200);
        } else 
            return response()->json([
                'success' => false,
                'message' => 'No category with id'
            ], 401);
    }
}
