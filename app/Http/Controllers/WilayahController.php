<?php

namespace App\Http\Controllers;

use App\Models\Wilayah;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class WilayahController extends Controller
{
    public function index() {
        $wilayah=Wilayah::all();
        $response =[
            'message' => 'succes menampilkan wilayah',
            'data' => $wilayah
       ];
       return response()->json($response,Response::HTTP_OK);
    }

    
    public function store(Request $request) {
        // return $request;
        $cek=Wilayah::where('HQ',1)->first();
        
        $validator=Validator::make($request->all(),[
            'name' => 'required|string',
            'email' => 'required|string|email',
            'kota' => 'required|string',
            'alamat' => 'required|string',
            'nomor'=>'required|numeric|min:6',
            
       ]);
     
       if($validator->fails()){
         return response()->json($validator->errors(), 
         Response::HTTP_UNPROCESSABLE_ENTITY);
       }
       if($cek != null and $request->HQ==1){
        $response= [
            'message'=>'HQ sudah ada'
        ];
        return response()->json($response,Response::HTTP_UNPROCESSABLE_ENTITY);
       } 
      
       try {
            $data=array(
                'name' => $request->name,
                'email' =>$request->email,
                'kota' =>$request->kota,
                'alamat'=>$request->alamat,
                'nomor' =>$request->nomor,
                'HQ'=>($request->HQ ? true : false)
              );       
             
        $wilayah=Wilayah::create($data);
        $response= [
            'message'=>'add succes ',
            'data' => $wilayah
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

    public function show($id){
        // dd($id);
        $wilayah=Wilayah::find($id);
        $response =[
            'message' => 'detail data',
            'data' => $wilayah
       ];
       return response()->json($response,Response::HTTP_OK);
    }

    public function update(Request $request, $id){
        // dd($request->name);
        $wilayah=Wilayah::findOrFail($id);
        $validator=Validator::make($request->all(),[
            'name' => 'required|string',
            'email' => 'required|string|email',
            'kota' => 'required|string',
            'alamat' => 'required|string',
            'nomor'=>'required|numeric|min:6',
           ]);
           if($validator->fails()){
             return response()->json($validator->errors(), 
             Response::HTTP_UNPROCESSABLE_ENTITY);
           }
           try {
            $wilayah->update($request->all());
            $response= [
                'message'=>'transaction update',
                'data' => $wilayah
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
        $wilayah=Wilayah::findOrFail($id);
        try {
            $wilayah->delete();
        $response=[
            'message' =>'wilayah deleted'
        ];
        return response()->json($response,Response::HTTP_OK);
        } catch (QueryException $e) {
            return response()->json([
                'message' =>"failed".$e->errorInfo
            ]);
        }
        
    }
}
