<?php

namespace App\Http\Controllers;

use App\Models\khas;
use App\Models\laporan;
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
            'kode'=>'required',
            'nama'=>'required',
            'saldo_awal'=>'required',
            'kode_akun'=>'required',
            'keterangan'=>'required'
       ]);
      
       if($validator->fails()){
         return response()->json($validator->errors(), 
         Response::HTTP_UNPROCESSABLE_ENTITY);
       }
    //    try {
            $user=auth()->user();
            // dd($user);
             $data=array(
                'kode'=>$request->kode,
                'nama'=>$request->nama,
                'kode_akun'=>$request->kode_akun,
                'saldo_awal'=>$request->saldo_awal,
                'saldo_akhir'=>$request->saldo_awal,
                'keterangan'=>$request->keterangan,
                'edit_by'=>$user->name,
              );
            //   dd($data);
        $khas=khas::create($data);
          $data2=array(
            'KhasId'=>$khas->id,
            'debit'=>$request->saldo_awal,
            'kredit'=>0,
            'saldo_akhir'=>$request->saldo_awal
          );
        //   dd($data2);
          $laporan=laporan::create($data2);
       
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
            // 'saldo_awal'=>'required',
            'keterangan'=>'required'
       ]);
      
       if($validator->fails()){
         return response()->json($validator->errors(), 
         Response::HTTP_UNPROCESSABLE_ENTITY);
       }
       $user=auth()->user();
                $khas->kode_akun=$request->kode_akun;
                $khas->nama=$request->nama;
                // $khas->saldo_awal=$request->saldo_awal;
                // $khas->saldo_akhir=$request->saldo_awal;
                $khas->keterangan=$request->keterangan;
                $khas->edit_by=$user->name;
                $khas->kode=$request->kode;
                $khas->save();
            $response= [
                'message'=>'khas update',
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
