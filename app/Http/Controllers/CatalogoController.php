<?php

namespace App\Http\Controllers;

use App\Models\Catalogo;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Enums\HttpStatusCode;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
class CatalogoController extends Controller
{
    public function index(Request $request)
    {
        $categories = Catalogo::all();
        return response(['catalogos' => $categories], HttpStatusCode::OK);
    }

    public function create(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
          'NUM_CASA' => 'required|string|max:50',
          'CALLE_AVENIDA' => 'required|string|max:50',
        ]);

        if ($validator->fails())
        {
            return response(['error'=>$validator->errors()], HttpStatusCode::BadRequest);
        }
        Catalogo::create([
            'NUM_CASA'=>$data['NUM_CASA'],
            'CALLE_AVENIDA'=>$data['CALLE_AVENIDA'],
            'CIUDAD'=>$data['CIUDAD'],
            'COLONIA'=>$data['COLONIA'],
            'CODIGO_POSTAL'=>$data['CODIGO_POSTAL'],
            'DEPARTAMENTO'=>$data['DEPARTAMENTO'],
            'MUNICIPIO'=>$data['MUNICIPIO'],
            'ESTADO' =>$data['ESTADO']
        ]);
        return response(['message' => 'Created success'], HttpStatusCode::Created);
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        $category = Catalogo::find($id);

        return response(['catalogo' => $category], HttpStatusCode::OK);
    }

    public function edit(Catalogo $category)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
          'NUM_CASA' => 'required|string|max:50',
          'CALLE_AVENIDA' => 'required|string|max:50',
        ]);

        if ($validator->fails())
        {
            return response(['error'=>$validator->errors()], HttpStatusCode::BadRequest);
        }

        $catalogo = Catalogo::where('ID_CATALOGO', '=', $id)->update([
          'NUM_CASA'=>$data['NUM_CASA'],
            'CALLE_AVENIDA'=>$data['CALLE_AVENIDA'],
            'CIUDAD'=>$data['CIUDAD'],
            'COLONIA'=>$data['COLONIA'],
            'CODIGO_POSTAL'=>$data['CODIGO_POSTAL'],
            'DEPARTAMENTO'=>$data['DEPARTAMENTO'],
            'MUNICIPIO'=>$data['MUNICIPIO'],
            'ESTADO' =>$data['ESTADO']
        ]);
        return response(['data' => 'Updated success'], HttpStatusCode::OK);
    }

    public function destroy($id)
    {
      Catalogo::where('ID_CATALOGO', '=', $id)->delete();
      return response(['data' => 'Delete success'], HttpStatusCode::OK);
    }
}
