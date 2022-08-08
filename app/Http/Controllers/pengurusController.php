<?php

namespace App\Http\Controllers;

use App\Models\pengurus;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class pengurusController extends Controller
{
    public function index() {
        $pengurus=pengurus::with('member','jabatan')->get();
       return response()->json($pengurus,200);
    }

    public function store(Request $request){
        $validator=Validator::make($request->all(),[
            'jabatanId'=>'required',
            'memberId'=>'required',
            'username'=>'required',
            'status'=>'required'
       ]);
      
       if($validator->fails()){
         return response()->json($validator->errors(), 
         Response::HTTP_UNPROCESSABLE_ENTITY);
       }
       try {
            $data=array(
                'jabatanId'=>$request->jabatanId,
                'memberId'=>$request->memberId,
                'username'=>$request->username,
                'status'=>$request->status
              );
        $pengurus=pengurus::create($data);
        $response= [
            'message'=>'add succes ',
            'data' => $pengurus
        ];
        return response()->json($response,Response::HTTP_CREATED);
       
       } catch (QueryException $e) {
        return response()->json([
            'message'=>"failed".$e->errorInfo
        ]);
       }    
    }

    public function show($id){
        $pengurus=pengurus::where('id',$id)->first();
        $response =[
            'message' => 'detail data',
            'data' => $pengurus
       ];
       return response()->json($response,Response::HTTP_OK);
    }
    public function update(Request $request, $id){
        $pengurus=pengurus::findOrFail($id);
        $validator=Validator::make($request->all(),[
            'jabatanId'=>'required',
            'memberId'=>'required',
            'username'=>'required',
            'status'=>'required'
        ]);
           if($validator->fails()){
             return response()->json($validator->errors(), 
             Response::HTTP_UNPROCESSABLE_ENTITY);
           }
           try {
            $pengurus->update($request->all());
            $response= [
                'message'=>'pengurus update',
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
        $pengurus=pengurus::findOrFail($id);
        try {
            $pengurus->delete();
        $response=[
            'message' =>'pengurus deleted'
        ];
        return response()->json($response,Response::HTTP_OK);
        } catch (QueryException $e) {
            return response()->json([
                'message' =>"failed".$e->errorInfo
            ]);
        }
        
    }
}