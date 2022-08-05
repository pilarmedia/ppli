<?php

namespace App\Http\Controllers;

use App\Models\mitra;
use App\Models\kontak;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class mitraController extends Controller
{
    public function index()
    {
        $data=mitra::with('kontak')->get();
        $response =[
            'message' => 'succes menampilkan mitra',
            'data' => $data
       ];
       return response()->json($response,Response::HTTP_OK);
    }
    public function selectOption(){
        $konta=kontak::all();
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
        $mitra=mitra::create($data);
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

        $data=mitra::with('kontak')->where('id',$id)->first();
        $response =[
            'message' => 'detail data',
            'data' => $data
       ];
       return response()->json($response,Response::HTTP_OK);
    }
 

    public function update(Request $request, $id)
    {
        
        $data=mitra::findOrFail($id);
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
        $data=mitra::findOrFail($id);
        try {
            $industri->delete();
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
