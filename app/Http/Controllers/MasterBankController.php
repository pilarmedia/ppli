<?php

namespace App\Http\Controllers;

use App\Models\b\Bank;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class MasterBankController extends Controller
{
    public function index(){
        $bank=Bank::all();
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
        $bank=Bank::create($data);
        $response= [
            'message'=>'add succes ',
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
        $bank=Bank::where('id',$id)->first();
        $response =[
            'message' => 'detail data',
            'data' => $bank
       ];
       return response()->json($response,Response::HTTP_OK);
    }

    public function update(Request $request, $id){
        // dd($request->name);
        $data=Bank::findOrFail($id);
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
                'message'=>'bank update',
            ];
            return response()->json($response,Response::HTTP_OK);
           } catch (QueryException $e) {
            return response()->json([
                'message'=>"failed".$e->errorInfo
            ]);
           }
    }

    public function destroy($id){
        $data=Bank::findOrFail($id);
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
