<?php

namespace App\Http\Controllers;

use App\Models\kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class kategoriController extends Controller
{
    public function index()
    {
        $kategori=kategori::all();
        $response =[
            'message' => 'succes menampilkan kategori',
            'data' => $kategori
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
        $kategori=kategori::create($data);
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
        $kategori=kategori::find($id);
        $response =[
            'message' => 'detail data',
            'data' => $kategori
       ];
       return response()->json($response,Response::HTTP_OK);
    }

    public function update(Request $request, $id)
    {
        // dd($request->name);
        $kategori=kategori::findOrFail($id);
        $validator=Validator::make($request->all(),[
            'name' => 'required'
           ]);
           if($validator->fails()){
             return response()->json($validator->errors(), 
             Response::HTTP_UNPROCESSABLE_ENTITY);
           }
           try {
            $kategori->update($request->all());
            $response= [
                'message'=>'kategori update',
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
        $kategpri=kategori::findOrFail($id);
        try {
            $kategori->delete();
        $response=[
            'message' =>'kategori deleted'
        ];
        return response()->json($response,Response::HTTP_OK);
        } catch (QueryException $e) {
            return response()->json([
                'message' =>"failed".$e->errorInfo
            ]);
        }
        
    }
}
