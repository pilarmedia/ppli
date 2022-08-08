<?php

namespace App\Http\Controllers;

use App\Models\Cities;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class CitiesController extends Controller
{
    public function index()
    {
        $industri=Cities::with('provinsi')->get();
        $response =[
            'message' => 'succes menampilkan Cities',
            'data' => $industri
       ];
       return response()->json($response,Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'provinsiId' => 'required',
            'name' => 'required|string'
       ]);
      
       if($validator->fails()){
         return response()->json($validator->errors(), 
         Response::HTTP_UNPROCESSABLE_ENTITY);
       }
       try {
             $data=array(
                'provinsiId' => $request->provinsiId,
                'name' => $request->name,
              );
        $industri=Cities::create($data);
        $response= [
            'message'=>'add succes '
        
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
        $cities=Cities::with('provinsi')->where('id',$id)->first();
        $response =[
            'message' => 'detail data',
            'data' => $cities
       ];
       return response()->json($response,Response::HTTP_OK);
    }
    public function show2($id)
    {
        // dd($id);
        $cities=Cities::where('provinsiId',$id)->get();
        $response =[
            'message' => 'detail data',
            'data' => $cities
       ];
       return response()->json($response,Response::HTTP_OK);
    }

    
    public function update(Request $request, $id)
    {
        // dd($request->name);
        $cities=Cities::findOrFail($id);
        $validator=Validator::make($request->all(),[
            'name' => 'required',
            'provinsiId'=>'required'
           ]);
           if($validator->fails()){
             return response()->json($validator->errors(), 
             Response::HTTP_UNPROCESSABLE_ENTITY);
           }
           try {
            $cities->update($request->all());
            $response= [
                'message'=>'transaction update',
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
        $industri=Cities::findOrFail($id);
        try {
            $industri->delete();
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
