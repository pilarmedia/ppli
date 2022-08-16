<?php

namespace App\Http\Controllers;

use App\Models\Provinsi;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class provinsiController extends Controller
{
    public function index()
    {
        $provinsi=Provinsi::all();
        $response =[
            'message' => 'succes menampilkan provinsi',
            'data' => $provinsi
       ];
       return response()->json($response,Response::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
  

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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
        $provinsi=Provinsi::create($data);
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
        $provinsi=Provinsi::find($id);
        $response =[
            'message' => 'detail data',
            'data' => $provinsi
       ];
       return response()->json($response,Response::HTTP_OK);
    }


    public function update(Request $request, $id)
    {
        // dd($request->name);
        $provinsi=Provinsi::findOrFail($id);
        $validator=Validator::make($request->all(),[
            'name' => 'required'
           ]);
           if($validator->fails()){
             return response()->json($validator->errors(), 
             Response::HTTP_UNPROCESSABLE_ENTITY);
           }
           try {
            $provinsi->update($request->all());
            $response= [
                'message'=>'provinsi update',
            
            ];
            return response()->json($response,Response::HTTP_OK);
           } catch (QueryException $e) {
            return response()->json([
                'message'=>"failed".$e->errorInfo
            ]);
           }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $provinsi=Provinsi::findOrFail($id);
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
