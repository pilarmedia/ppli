<?php

namespace App\Http\Controllers;

use App\Models\khas;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class MasterKhasController extends Controller
{
    public function index(Request $request){

            $data=khas::with('akun')->get();
            $response =[
                'message' => 'succes menampilkan akun',
                'data' => $data
           ];
           return response()->json($response,Response::HTTP_OK);       
    }
    public function selectOption(){
        $data=akun::where('induk',false)->get();
            $response =[
                'message' => 'succes menampilkan akun',
                'data' => $data
           ];
           return response()->json($response,Response::HTTP_OK); 
    }

    public function store(Request $request) {
        $validator=Validator::make($request->all(),[
            'kode_akun'=>'required',
            'nama'=>'required',
            'saldo_awal'=>'required',
            'keterangan'=>'required'
       ]);
      
       if($validator->fails()){
         return response()->json($validator->errors(), 
         Response::HTTP_UNPROCESSABLE_ENTITY);
       }
       try {
            $user=auth()->user();
             $data=array(
                'kode_akun'=>$request->kode_akun,
                'nama'=>$request->nama,
                'saldo_awal'=>$request->saldo_awal,
                'saldo_akhir'=>$request->saldo_awal,
                'keterangan'=>$request->keterangan,
                'edit_by'=>$user->name,
              );
        $khas=khas::create($data);
       
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
        $data=khas::with('akun')->where('id',$id)->first();
        $response =[
            'message' => 'detail data',
            'data' => $data
       ];
       return response()->json($response,Response::HTTP_OK);
    }

    public function update(Request $request, $id){
        $khas=khas::findOrFail($id);
        $validator=Validator::make($request->all(),[
            'kode_akun'=>'required',
            'nama'=>'required',
            'saldo_awal'=>'required',
            'keterangan'=>'required'
       ]);
      
       if($validator->fails()){
         return response()->json($validator->errors(), 
         Response::HTTP_UNPROCESSABLE_ENTITY);
       }
       $user=auth()->user();
                $khas->kode_akun=$request->kode_akun;
                $khas->nama=$request->nama;
                $khas->saldo_awal=$request->saldo_awal;
                $khas->saldo_akhir=$request->saldo_awal;
                $khas->keterangan=$request->keterangan;
                $khas->edit_by=$user->name;
                $akun->save();
            $response= [
                'message'=>'akun update',
                'data' => $khas
            ];
            return response()->json($response,Response::HTTP_OK);
    }

    public function destroy($id){
        $data=khas::findOrFail($id);
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
