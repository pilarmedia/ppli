<?php

namespace App\Http\Controllers;

use App\Models\DPW;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class dpwController extends Controller
{
    public function index()
    {
        $dpw=DPW::all();
        $response =[
            'message' => 'succes dpw',
            'data' => $dpw
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
            'kode'=>'required',
            'nama'=>'required',
            'alamat_kantor'=>'required',
            'email'=>'required|email',
            'nomor'=>'required|numeric|min:6'
       ]);
      
       if($validator->fails()){
         return response()->json($validator->errors(), 
         Response::HTTP_UNPROCESSABLE_ENTITY);
       }
       try {
             $data=array(
                'kode' => $request->kode,
                'nama' => $request->nama,
                'alamat_kantor'=>$request->alamat_kantor,
                'email'=>$request->email,
                'nomor'=>$request->nomor
              );
        $dpw=DPW::create($data);
        $response= [
            'message'=>'add succes ',
            'data' => $dpw
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
        $dpw=DPW::find($id);
        $response =[
            'message' => 'detail data',
            'data' => $dpw
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
        $industri=DPW::findOrFail($id);
        $validator=Validator::make($request->all(),[
            'kode'=>'required',
            'nama'=>'required',
            'alamat_kantor'=>'required',
            'email'=>'required|email',
            'nomor'=>'required|numeric|min:6'
           ]);
           if($validator->fails()){
             return response()->json($validator->errors(), 
             Response::HTTP_UNPROCESSABLE_ENTITY);
           }
           try {
            $dpw->update($request->all());
            $response= [
                'message'=>'transaction update',
                'data' => $dpw
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
        $dpw=DPW::findOrFail($id);
        try {
            $dpw->delete();
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
