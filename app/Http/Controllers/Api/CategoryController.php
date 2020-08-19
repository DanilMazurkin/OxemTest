<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\CategoryFormRequest;
use App\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();

        return response()->json([
            $categories
        ], 200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
    
    public function store(CategoryFormRequest $request)
    {
        $name = $request->input('name');
        $external_id = $request->input('external_id');


        Category::create([
            'name' => $name,
            'external_id' => $external_id,

        ]);
       
        return response()->json([
            'message' => 'You were successfully create category!'
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryFormRequest $request, $id)
    {
        $name = $request->input('name');
        $external_id = $request->input('external_id');

        $category = Category::find($id);

        if (isset($category)) 
        {
            Category::where('id', $id)->update([
                'name' => $name,
                'external_id' => $external_id
            ]);

            return response()->json([
                'message' => 'You were successfully update category!'
            ], 200);
        } else 
            return response()->json([
                'message' => 'No category with id'
            ], 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   

        $category = Category::find($id);

        if (isset($category)) 
        {
            Category::destroy($id);

            return response()->json([
                'message' => 'You were successfully delete category!'
            ], 200);
        } else 
            return response()->json([
                'message' => 'No category with id'
            ], 200);
    }
}
