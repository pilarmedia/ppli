<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MasterAkunController extends Controller
{
    public function index(){
        $data=bank::all();
        $response =[
            'message' => 'succes menampilkan bank',
            'data' => $bank
       ];
       return response()->json($response,Response::HTTP_OK);
    }

    public function store(Request $request) {
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
        $bank=bank::create($data);
        $response= [
            'message'=>'add succes ',
            'data' => $bank
        ];
        return response()->json($response,Response::HTTP_CREATED);
       
       } catch (QueryException $e) {
        return response()->json([
            'message'=>"failed".$e->errorInfo
        ]);
       }    
  
 
    }

    public function show($id)  {
        // dd($id);
        $data=bank::where('id',$id)->first();
        $response =[
            'message' => 'detail data',
            'data' => $bank
       ];
       return response()->json($response,Response::HTTP_OK);
    }

    public function update(Request $request, $id){
        // dd($request->name);
        $data=bank::findOrFail($id);
        $validator=Validator::make($request->all(),[
            'name' => 'required',
           ]);
           if($validator->fails()){
             return response()->json($validator->errors(), 
             Response::HTTP_UNPROCESSABLE_ENTITY);
           }
           try {
            $data->update($request->all());
            $response= [
                'message'=>'transaction update',
                'data' => $data
            ];
            return response()->json($response,Response::HTTP_OK);
           } catch (QueryException $e) {
            return response()->json([
                'message'=>"failed".$e->errorInfo
            ]);
           }
    }

    public function destroy($id){
        $data=bank::findOrFail($id);
        try {
            $data->delete();
        $response=[
            'message' =>'bank deleted'
        ];
        return response()->json($response,Response::HTTP_OK);
        } catch (QueryException $e) {
            return response()->json([
                'message' =>"failed".$e->errorInfo
            ]);
        }
        
    }
}
