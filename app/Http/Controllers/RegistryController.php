<?php

namespace App\Http\Controllers;

use App\Models\Registry;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Enums\HttpStatusCode;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
class RegistryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $registries = Registry::all();
        return response(['registries' => $registries], HttpStatusCode::OK);
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
            'address' => 'required|string',
            'phone' => 'required|string',
		]);

        if ($validator->fails())
        {
            return response(['error'=>$validator->errors()], HttpStatusCode::BadRequest);
        }

        if ($data['archivador_id']) {
            Registry::create([
                'archivador_id'=>$data['archivador_id'],
                'name'=>$data['name'],
                'description'=>$data['description'],
                'address' => $data['address'],
                'phone' => $data['phone']
            ]);
        } else {
            Registry::create([
                'archivador_id'=>$data['archivador_id'],
                'name'=>$data['name'],
                'description'=>$data['description'],
                'address' => $data['address'],
                'phone' => $data['phone']
            ]);
        }
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
     * @param  \App\Models\Registry  $registry
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $registry = Registry::find($id);

        return response(['registry' => $registry], HttpStatusCode::OK);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Registry  $registry
     * @return \Illuminate\Http\Response
     */
    public function edit(Registry $registry)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Registry  $registry
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
          'name' => 'required|string|max:100',
          'description' => 'required|string',
          'address' => 'required|string',
          'phone' => 'required|string',
        ]);

        if ($validator->fails())
        {
            return response(['error'=>$validator->errors()], HttpStatusCode::BadRequest);
        }

        $registry = Registry::find($id);

        $registry->archivador_id = $data['archivador_id'];
        $registry->name = $data['name'];
        $registry->description = $data['description'];
        $registry->address = $data['address'];
        $registry->phone = $data['phone'];
        $registry->save();

        return response(['data' => 'Updated success'], HttpStatusCode::OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Registry  $registry
     * @return \Illuminate\Http\Response
     */
    public function destroy(Registry $registry)
    {
        //
    }
}
