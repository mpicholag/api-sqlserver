<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Registry;
use App\Models\Archivador;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Enums\HttpStatusCode;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;

class DocumentController extends Controller
{
    public function index(Request $request)
    {
        $notify = $request->input('notify');
        $registry = $request->input('registry');

        if ($notify) {
            $documents = Document::where('notify', true)->get();
        } else if ($registry) {
            $documents = Document::where('registry_id', $registry)->get();
        } else {
            $documents = Document::all();
        }

        return response(['documents' => $documents], HttpStatusCode::OK);
    }

    public function archivador() {
        $archivador = Archivador::all();
        $dataArchivador = array();

        foreach ($archivador as $item) {
            $registries = Registry::where('archivador_id', '=', $item['id'])->get();
            $dataArchivador [] = ['id' => $item['id'],'name' => $item['name'], 'registries' => $registries];
        }

        return response(['archivadores' => $dataArchivador], HttpStatusCode::OK);
    }

    public function upload(Request $request) {
        $data = $request->all();
        if ($data['file']) {
            $file = $data['file'];
            $extension = $data['extension'];
            $times = (string)now()->timestamp;
            $fileName = "document-{$times}.{$extension}";
            Storage::disk('public')->put($fileName, base64_decode($file));
        }

        return response(['data' => $fileName], HttpStatusCode::OK);
    }

    public function download(Request $request) {
        $data = $request->input('file');
        return Storage::disk('public')->download($data);
    }

    public function create(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
			'user_id' => 'required',
            'category_id' => 'required',
			'subcategory_id' => 'required',
            'registry_id' => 'required',
            'title' => 'required|string|max:45',
            'description' => 'required|string',
            'firm_date' => 'required|string',
            'renovation_date' => 'required|string',
            'expiration_date' => 'required|string',
		]);

        if ($validator->fails())
        {
            return response(['error'=>$validator->errors()], HttpStatusCode::BadRequest);
        }

        $fileName = null;

        if ($data['file']) {
            $file = $data['file'];
            $extension = $data['extension'];
            $times = (string)now()->timestamp;
            $fileName = "document-{$times}.{$extension}";
            Storage::disk('public')->put($fileName, base64_decode($file));
        }

        Document::create([
            'title'=>$data['title'],
            'description'=>$data['description'],
            'user_id'=>$data['user_id'],
            'category_id'=>$data['category_id'],
            'subcategory_id'=>$data['subcategory_id'],
            'registry_id'=>$data['registry_id'],
            'firm_date'=>Carbon::createFromFormat('d-m-Y', $data['firm_date'])->format('Y-m-d'),
            'renovation_date'=>Carbon::createFromFormat('d-m-Y', $data['renovation_date'])->format('Y-m-d'),
            'expiration_date'=>Carbon::createFromFormat('d-m-Y', $data['expiration_date'])->format('Y-m-d'),
            'path_document'=> $fileName,
            'notify' => $data['notify']
        ]);
        return response(['message' => 'Created success'], HttpStatusCode::Created);
    }

    public function show($id)
    {
        $document = Document::find($id);

        $document->firm_date = Carbon::createFromFormat('Y-m-d', $document->firm_date)->format('d-m-Y');
        $document->renovation_date = Carbon::createFromFormat('Y-m-d', $document->renovation_date)->format('d-m-Y');
        $document->expiration_date = Carbon::createFromFormat('Y-m-d', $document->expiration_date)->format('d-m-Y');

        return response(['document' => $document], HttpStatusCode::OK);
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
			'user_id' => 'required',
			'category_id' => 'required',
            'subcategory_id' => 'required',
            'registry_id' => 'required',
            'title' => 'required|string|max:45',
            'description' => 'required|string',
            'firm_date' => 'required|string',
            'renovation_date' => 'required|string',
            'expiration_date' => 'required|string'
		]);

        if ($validator->fails())
        {
            return response(['error'=>$validator->errors()], HttpStatusCode::BadRequest);
        }

        $document = Document::find($id);

        $document->title = $data['title'];
        $document->description = $data['description'];
        $document->category_id = $data['category_id'];
        $document->subcategory_id = $data['subcategory_id'];
        $document->registry_id = $data['registry_id'];
        $document->firm_date = Carbon::createFromFormat('d-m-Y', $data['firm_date'])->format('Y-m-d');
        $document->renovation_date = Carbon::createFromFormat('d-m-Y', $data['renovation_date'])->format('Y-m-d');
        $document->expiration_date = Carbon::createFromFormat('d-m-Y', $data['expiration_date'])->format('Y-m-d');
        $document->notify = $data['notify'];
        if ($data['file']) {
            $file = $data['file'];
            $extension = $data['extension'];
            $times = (string)now()->timestamp;
            $fileName = "document-{$times}.{$extension}";
            Storage::disk('public')->put($fileName, base64_decode($file));
            Storage::disk('public')->delete($document->path_document);

            $document->path_document = $fileName;
        }

        $document->save();

        return response(['data' => 'Updated success'], HttpStatusCode::OK);
    }
}
