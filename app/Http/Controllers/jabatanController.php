<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
//jemb
class jabatanController extends Controller
{
    public function index()
    {
        $jabatan=Jabatan::all();
        $response =[
            'message' => 'succes menampilkan jabatan',
            'data' => $jabatan
       ];
       return response()->json($response,Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'name' => 'required|string',
            'level'=> 'required'
       ]);
      
       if($validator->fails()){
         return response()->json($validator->errors(), 
         Response::HTTP_UNPROCESSABLE_ENTITY);
       }
       try {
             $data=array(
                'name' => $request->name,
                'level' => $request->level,
              );
        $jabatan=Jabatan::create($data);
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
        $jabatan=Jabatan::find($id);
        $response =[
            'message' => 'detail data',
            'data' => $jabatan
       ];
       return response()->json($response,Response::HTTP_OK);
    }

    public function update(Request $request, $id)
    {
        // dd($request->name);
        $jabatan=Jabatan::findOrFail($id);
        $validator=Validator::make($request->all(),[
            'name' => 'required',
            'level' => 'required'
           ]);
           if($validator->fails()){
             return response()->json($validator->errors(), 
             Response::HTTP_UNPROCESSABLE_ENTITY);
           }
           try {
            $jabatan->update($request->all());
            $response= [
                'message'=>'jabatan update',
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
        $provinsi=Jabatan::findOrFail($id);
        try {
            $provinsi->delete();
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
