<?php

namespace App\Http\Controllers;

use App\Models\Subcategory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Enums\HttpStatusCode;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
class SubcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $category = $request->input('category');

        if ($category) {
            $categories = Subcategory::where('category_id', $category)->get();
        } else {
            $categories = Subcategory::all();
        }
        return response(['subcategories' => $categories], HttpStatusCode::OK);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
          'category_id' => 'required',
          'name' => 'required|string|max:100',
          'description' => 'required|string',
        ]);

        if ($validator->fails())
        {
            return response(['error'=>$validator->errors()], HttpStatusCode::BadRequest);
        }
        Subcategory::create([
            'category_id' => $data['category_id'],
            'name'=>$data['name'],
            'description'=>$data['description'],
        ]);
        return response(['message' => 'Created success'], HttpStatusCode::Created);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $subcategory = Subcategory::find($id);

        return response(['subcategory' => $subcategory], HttpStatusCode::OK);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Subcategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function edit(Subcategory $subcategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Subcategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
          'category_id' => 'required',
          'name' => 'required|string|max:100',
          'description' => 'required|string',
        ]);

        if ($validator->fails())
        {
            return response(['error'=>$validator->errors()], HttpStatusCode::BadRequest);
        }

        $subcategory = Subcategory::find($id);

        $subcategory->name = $data['name'];
        $subcategory->description = $data['description'];
        $subcategory->category_id = $data['category_id'];
        $subcategory->save();

        return response(['data' => 'Updated success'], HttpStatusCode::OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subcategory  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subcategory $subcategory)
    {
        //
    }
}
