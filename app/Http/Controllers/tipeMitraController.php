<?php

namespace App\Http\Controllers;

use App\Models\tipeMitra;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class tipeMitraController extends Controller
{
    public function index()
    {
        $data=tipeMitra::all();
        $response =[
            'message' => 'succes menampilkan tipe mitra',
            'data' => $data
       ];
       return response()->json($response,Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'name' => 'required|string'
       ]);
      
       if($validator->fails()){
         return response()->json($validator->errors(), 
         Response::HTTP_UNPROCESSABLE_ENTITY);
       }
       try {
             $data=array(
                'name' => $request->name,
              );
        $tipeMitra=tipeMitra::create($data);
        $response= [
            'message'=>'add succes ',
        
        ];
        return response()->json($response,Response::HTTP_CREATED);
       
       } catch (QueryException $e) {
        return response()->json([
            'message'=>"failed".$e->errorInfo
        ]);
       }    
    return response()->json([
        'status' => 'success',
    ]);
 
    }

    public function show($id)
    {
        // dd($id);
        $data=tipeMitra::find($id);
        $response =[
            'message' => 'detail data',
            'data' => $data
       ];
       return response()->json($response,Response::HTTP_OK);
    }

  
    public function update(Request $request, $id)
    {
        // dd($request->name);
        $tipeMitra=tipeMitra::findOrFail($id);
        $validator=Validator::make($request->all(),[
            'name' => 'required'
           ]);
           if($validator->fails()){
             return response()->json($validator->errors(), 
             Response::HTTP_UNPROCESSABLE_ENTITY);
           }
           try {
            $tipeMitra->update($request->all());
            $response= [
                'message'=>'tipe mitra update',
       
            ];
            return response()->json($response,Response::HTTP_OK);
           } catch (QueryException $e) {
            return response()->json([
                'message'=>"failed".$e->errorInfo
            ]);
           }
    }

    public function destroy($id)
    {
        $tipeMitra=tipeMitra::findOrFail($id);
        try {
            $tipeMitra->delete();
        $response=[
            'message' =>'transaction deleted'
        ];
        return response()->json($response,Response::HTTP_OK);
        } catch (QueryException $e) {
            return response()->json([
                'message' =>"failed".$e->errorInfo
            ]);
        }
        
    }
}
