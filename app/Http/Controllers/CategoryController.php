<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Enums\HttpStatusCode;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $registry = $request->input('registry');

        if ($registry) {
            $categories = Category::where('registry_id', $registry)->get();
        } else {
            $categories = Category::all();
        }
        return response(['categories' => $categories], HttpStatusCode::OK);
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
			'name' => 'required|string|max:100',
			'description' => 'required|string',
		]);

        if ($validator->fails())
        {
            return response(['error'=>$validator->errors()], HttpStatusCode::BadRequest);
        }
        Category::create([
            'registry_id'=>$data['registry_id'],
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
        $category = Category::find($id);

        return response(['category' => $category], HttpStatusCode::OK);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
			'name' => 'required|string|max:100',
			'description' => 'required|string',
		]);

        if ($validator->fails())
        {
            return response(['error'=>$validator->errors()], HttpStatusCode::BadRequest);
        }

        $category = Category::find($id);

        $category->registry_id = $data['registry_id'];
        $category->name = $data['name'];
        $category->description = $data['description'];
        $category->save();

        return response(['data' => 'Updated success'], HttpStatusCode::OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        //
    }
}
