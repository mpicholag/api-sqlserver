<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Archivador;
use App\Http\Controllers\Controller;
use App\Enums\HttpStatusCode;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ArchivadorController extends Controller
{
    public function index()
    {
        $archivadors = Archivador::all();
        return response(['archivadors' => $archivadors], HttpStatusCode::OK);
    }

    public function create(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
          'name' => 'required|string|max:45',
          'description' => 'required|string'
		]);

        if ($validator->fails())
        {
            return response(['error'=>$validator->errors()], HttpStatusCode::BadRequest);
        }
        Archivador::create([
            'name'=>$data['name'],
            'description'=>$data['description']
        ]);
        return response(['message' => 'Created success'], HttpStatusCode::Created);
    }

    public function show($id)
    {
        $archivero = Archivador::find($id);

        return response(['archivador' => $archivero], HttpStatusCode::OK);
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
          'name' => 'required|string|max:45',
          'description' => 'required|string'
		    ]);

        if ($validator->fails())
        {
            return response(['error'=>$validator->errors()], HttpStatusCode::BadRequest);
        }

        $archivero = Archivador::find($id);

        $archivero->name = $data['name'];
        $archivero->description = $data['description'];

        $archivero->save();

        return response(['data' => 'Updated success'], HttpStatusCode::OK);
    }
}
