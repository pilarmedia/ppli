<?php

namespace App\Http\Controllers;

use App\Models\akun;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class MasterAkunController extends Controller
{
    public function getindex(){
        $data=akun::with('wilayah')->get();
        $response =[
            'message' => 'succes menampilkan akun',
            'data' => $data
       ];
       return response()->json($response,Response::HTTP_OK);
    }

    public function index(Request $request){
        if($request->wilayah ==='0'){
            $data=akun::with('wilayah')->get();
            $response =[
                'message' => 'succes menampilkan akun',
                'data' => $data
           ];
           return response()->json($response,Response::HTTP_OK);
        } else{
        // $wilayah=Wilayah::where('id',$request->wilayah)->first();
        $data=akun::where('WilayahId',$request->wilayah)->with('Wilayah')->get();
         return response()->json([
             'data' => $data,           
         ]);   
         
        }
        
    }
    public function selectOption(){
        $data=akun::where('induk',true)->get();
            $response =[
                'message' => 'succes menampilkan kategori',
                'data' => $data
           ];
           return response()->json($response,Response::HTTP_OK); 
    }

    public function store(Request $request) {
        $cek=akun::where('kode',$request->kode)->first();
        if($cek){
            return response()->json('kode sudah ada');
        }
        $validator=Validator::make($request->all(),[
            'wilayah'=>'required',
            'kode'=>'required',
            'nama_akun'=>'required',
            'kategori_akun'=>'required',
       ]);
      
       if($validator->fails()){
         return response()->json($validator->errors(), 
         Response::HTTP_UNPROCESSABLE_ENTITY);
       }
       try {
             $data=array(
                'WilayahId'=>$request->wilayah,
                'kode'=>$request->kode,
                'nama_kategori'=>$request->nama_kategori,
                'nama_akun'=>$request->nama_akun,
                'induk'=>($request->induk ? true : false),
                'kategori_akun'=>$request->kategori_akun,
              );
            //   dd($data);
        $akun=akun::create($data);
       
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
        $data=akun::with('wilayah')->where('id',$id)->first();
        $response =[
            'message' => 'detail data',
            'data' => $data
       ];
       return response()->json($response,Response::HTTP_OK);
    }

    public function update(Request $request, $id){
        $akun=akun::findOrFail($id);
        $validator=Validator::make($request->all(),[
            'wilayah'=>'required',
            'kode'=>'required',
            'nama_akun'=>'required',
            'kategori_akun'=>'required',
       ]);
           if($validator->fails()){
             return response()->json($validator->errors(), 
             Response::HTTP_UNPROCESSABLE_ENTITY);
           }
        
            
                $akun->WilayahId=$request->wilayah;
                $akun->kode=$request->kode;
                $akun->nama_kategori=$request->nama_kategori;
                $akun->nama_akun=$request->nama_akun;
                $akun->induk=($request->induk ?true:false);
                $akun->kategori_akun=$request->kategori_akun;
                $akun->save();
            $response= [
                'message'=>'akun update',
            ];
            return response()->json($response,Response::HTTP_OK);
        //    } catch (QueryException $e) {
        //     return response()->json([
        //         'message'=>"failed".$e->errorInfo
        //     ]);
        //    }
    }

    public function destroy($id){
        $data=akun::findOrFail($id);
        try {
            $data->delete();
        $response=[
            'message' =>'akun deleted'
        ];
        return response()->json($response,Response::HTTP_OK);
        } catch (QueryException $e) {
            return response()->json([
                'message' =>"failed".$e->errorInfo
            ]);
        }
        
    }
}
