<?php

namespace App\Http\Controllers;

use App\Models\DocumentHistory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Enums\HttpStatusCode;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
class DocumentHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        $document = $request->input('document');
        $documentHistories = DocumentHistory::where('document_id', $document)->get();
        return response(['document_histories' => $documentHistories], HttpStatusCode::OK);
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
          'document_id' => 'required',
          'description' => 'required|string',
          'address' => 'required|string',
        ]);

        if ($validator->fails())
        {
            return response(['error'=>$validator->errors()], HttpStatusCode::BadRequest);
        }
        DocumentHistory::create([
            'document_id'=>$data['document_id'],
            'description'=>$data['description'],
            'address' => $data['address']
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
     * @param  \App\Models\DocumentHistory  $category
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $provider = Provider::find($id);

        return response(['provider' => $provider], HttpStatusCode::OK);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DocumentHistory  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(DocumentHistory $provider)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
          'name' => 'required|string|max:100',
          'description' => 'required|string',
          'address' => 'required|string'
        ]);

        if ($validator->fails())
        {
            return response(['error'=>$validator->errors()], HttpStatusCode::BadRequest);
        }

        $history = DocumentHistory::find($id);

        $history->name = $data['name'];
        $history->description = $data['description'];
        $history->address = $data['address'];
        $history->save();

        return response(['data' => 'Updated success'], HttpStatusCode::OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DocumentHistory  $provider
     * @return \Illuminate\Http\Response
     */
    public function destroy(DocumentHistory $provider)
    {
        //
    }
}
