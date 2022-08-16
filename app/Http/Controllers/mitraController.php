<?php

namespace App\Http\Controllers;

use App\Models\Mitra;
use App\Models\Kontak;
use App\Models\TipeMitra;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class mitraController extends Controller
{
    public function index()
    {
        $data=Mitra::with('kontak')->get();
        $response =[
            'message' => 'succes menampilkan mitra',
            'data' => $data
       ];
       return response()->json($response,Response::HTTP_OK);
    }
    public function selectOptionKontak(){
        $data=Kontak::all();
        return response()->json($data, 200);
    }
    public function selectOptionTipeMitra(){
        $data=TipeMitra::all();
        return response()->json($data, 200);
    }

   
    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'kontakId'=>'required',
            'tipe_mitra'=>'required',
            'tanggal_bergabung'=>'required',
            'deskripsi'=>'required'
       ]);
      
       if($validator->fails()){
         return response()->json($validator->errors(), 
         Response::HTTP_UNPROCESSABLE_ENTITY);
       }
    //    try {
             $data=array(
                'kontakId'=>$request->kontakId,
                'tipe_mitra'=>$request->tipe_mitra,
                'tanggal_bergabung'=>$request->tanggal_bergabung,
                'deskripsi'=>$request->deskripsi
              );
        $mitra=Mitra::create($data);
        $response= [
            'message'=>'add succes ',
        ];
        return response()->json($response,Response::HTTP_CREATED);
       
    //    } catch (QueryException $e) {
    //     return response()->json([
    //         'message'=>"failed".$e->errorInfo
    //     ]);
    //    }    
 
 
    }

    public function show($id)
    {

        $data=Mitra::with('kontak')->where('id',$id)->first();
        $response =[
            'message' => 'detail data',
            'data' => $data
       ];
       return response()->json($response,Response::HTTP_OK);
    }
 

    public function update(Request $request, $id)
    {
        
        $data=Mitra::findOrFail($id);
        $validator=Validator::make($request->all(),[
            'kontakId'=>'required',
            'tipe_mitra'=>'required',
            'tanggal_bergabung'=>'required',
            'deskripsi'=>'required'
         ]);
           if($validator->fails()){
             return response()->json($validator->errors(), 
             Response::HTTP_UNPROCESSABLE_ENTITY);
           }
           try {
            $data->update($request->all());
            $response= [
                'message'=>' update berhasil',
             
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
        $data=Mitra::findOrFail($id);
        try {
            $data->delete();
        $response=[
            'message' =>'mitra deleted'
        ];
        return response()->json($response,Response::HTTP_OK);
        } catch (QueryException $e) {
            return response()->json([
                'message' =>"failed".$e->errorInfo
            ]);
        }
        
    }
}
