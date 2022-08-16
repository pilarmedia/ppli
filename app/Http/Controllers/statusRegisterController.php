<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StatusRegister;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class statusRegisterController extends Controller
{
    public function index()
    {
        $statusRegister=StatusRegister::all();
        $response =[
            'message' => 'succes menampilkan status register',
            'data' => $statusRegister
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
        $statusRegister=StatusRegister::create($data);
        $response= [
            'message'=>'add succes ',
            'data' => $statusRegister
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // dd($id);
        $statusRegister=StatusRegister::find($id);
        $response =[
            'message' => 'detail data',
            'data' => $statusRegister
       ];
       return response()->json($response,Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // dd($request->name);
        $statusRegister=StatusRegister::findOrFail($id);
        $validator=Validator::make($request->all(),[
            'name' => 'required'
           ]);
           if($validator->fails()){
             return response()->json($validator->errors(), 
             Response::HTTP_UNPROCESSABLE_ENTITY);
           }
           try {
            $statusRegister->update($request->all());
            $response= [
                'message'=>'transaction update',
                'data' => $statusRegister
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
        $statusRegister=StatusRegister::findOrFail($id);
        try {
            $statusRegister->delete();
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
