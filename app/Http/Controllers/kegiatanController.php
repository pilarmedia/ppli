<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class kegiatanController extends Controller
{
    public function index() {
        $kegiatan=Kegiatan::all();
       return response()->json($kegiatan,200);
    }

    public function store(Request $request){
        $validator=Validator::make($request->all(),[
           'nama_kegiatan'=>'required',
            'sifat_kegiatan'=>'required',
            'lokasi_kegiatan'=>'required',
            'tanggal_rencana'=>'required',
            'tanggal_realisasi'=>'required',
            'keterangan'=>'required'
       ]);
      
       if($validator->fails()){
         return response()->json($validator->errors(), 
         Response::HTTP_UNPROCESSABLE_ENTITY);
       }
       try {
             $data=array(
                'nama_kegiatan'=>$request->nama_kegiatan,
                'sifat_kegiatan'=>$request->sifat_kegiatan,
                'lokasi_kegiatan'=>$request->lokasi_kegiatan,
                'tanggal_rencana'=>$request->tanggal_rencana,
                'tanggal_realisasi'=>$request->tanggal_realisasi,
                'keterangan'=>$request->keterangan
              );
        $kegiatan=Kegiatan::create($data);
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

    public function show($id){
        $kegiatan=Kegiatan::where('id',$id)->first();
        $response =[
            'message' => 'detail data',
            'data' => $kegiatan
       ];
       return response()->json($response,Response::HTTP_OK);
    }
    public function update(Request $request, $id){
        $kegiatan=Kegiatan::findOrFail($id);
        $validator=Validator::make($request->all(),[
            'nama_kegiatan'=>'required',
             'sifat_kegiatan'=>'required',
             'lokasi_kegiatan'=>'required',
             'tanggal_rencana'=>'required',
             'tanggal_realisasi'=>'required',
             'keterangan'=>'required'
        ]);
           if($validator->fails()){
             return response()->json($validator->errors(), 
             Response::HTTP_UNPROCESSABLE_ENTITY);
           }
           try {
            $kegiatan->update($request->all());
            $response= [
                'message'=>'kegiatan update',
            ];
            return response()->json($response,Response::HTTP_OK);
           } catch (QueryException $e) {
            return response()->json([
                'message'=>"failed".$e->errorInfo
            ]);
           }
    }
    
    public function destroy($id){
        $kegiatan=Kegiatan::findOrFail($id);
        try {
            $kegiatan->delete();
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
