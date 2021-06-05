<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Http\Controllers\Controller;
use App\Enums\HttpStatusCode;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return response(['data' => $roles], HttpStatusCode::OK);
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
        Role::create([
            'name'=>$data['name'],
            'description'=>$data['description']
        ]);
        return response(['message' => 'Created success'], HttpStatusCode::Created);
    }

    public function show($id)
    {
        $role = Role::find($id);

        return response(['data' => $role], HttpStatusCode::OK);
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

        $role = Role::find($id);

        $role->name = $data['name'];
        $role->description = $data['description'];

        $role->save();

        return response(['data' => 'Updated success'], HttpStatusCode::OK);
    }
}
