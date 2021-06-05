<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AccessArchivador;
use App\Http\Controllers\Controller;
use App\Enums\HttpStatusCode;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AccessArchivadorController extends Controller
{
    public function index()
    {
        $userId = $request->input('userId');
        $archivadorId = $request->input('archivadorId');
        if ($userId) {
          $access = AccessArchivador::where('user_id', $userId)->get();
        } else if () {
          $access = AccessArchivador::where('archivador_id', $archivadorId)->get();
        } else {
          $access = AccessArchivador::all();
        }
        return response(['data' => $access], HttpStatusCode::OK);
    }

    public function create(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
          'user_id' => 'required',
          'archivador_id' => 'required'
		    ]);

        if ($validator->fails())
        {
            return response(['error'=>$validator->errors()], HttpStatusCode::BadRequest);
        }
        AccessArchivador::create([
            'user_id'=>$data['user_id'],
            'archivador_id'=>$data['archivador_id']
        ]);
        return response(['message' => 'Created success'], HttpStatusCode::Created);
    }

    public function destroy(Request $request)
    {
      $userId = $request->input('userId');
      $archivadorId = $request->input('archivadorId');
      $access = AccessArchivador::find(1);
      $access->delete();
    }
}
