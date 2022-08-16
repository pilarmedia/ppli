<?php

namespace App\Http\Controllers;

use DateTime;
use App\Models\Khas;
use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class MasterKhasController extends Controller
{
    public function index(){

            $data=Khas::with('akun')->get();
            $response =[
                'message' => 'succes menampilkan khas',
                'data' => $data
           ];
           return response()->json($response,Response::HTTP_OK);       
    }
    public function selectOption(){
        $data=Akun::where('induk',false)->get();
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
            date_default_timezone_set('Asia/Jakarta');
            $ldate = new DateTime('now');
             $data=array(
                'kode'=>$request->kode,
                'nama'=>$request->nama,
                'kode_akun'=>$request->kode_akun,
                'saldo_awal'=>$request->saldo_awal,
                'saldo_akhir'=>$request->saldo_awal,
                'keterangan'=>$request->keterangan,
                'tanggal'=>$ldate,
                'edit_by'=>$user->name,
              );
            //   dd($data);
        $khas=Khas::create($data);
          $data2=array(
            'KhasId'=>$khas->id,
            'debit'=>$request->saldo_awal,
            'kredit'=>0,
            'saldo_akhir'=>$request->saldo_awal
          );
        //   dd($data2);
          $laporan=Laporan::create($data2);
       
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
        $data=Khas::with('akun')->where('id',$id)->first();
        $response =[
            'message' => 'detail data',
            'data' => $data
       ];
       return response()->json($response,Response::HTTP_OK);
    }

    public function update(Request $request, $id){
        $khas=Khas::findOrFail($id);
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
       date_default_timezone_set('Asia/Jakarta');
            $ldate = new DateTime('now');
                $khas->kode_akun=$request->kode_akun;
                $khas->nama=$request->nama;
                // $khas->saldo_awal=$request->saldo_awal;
                // $khas->saldo_akhir=$request->saldo_awal;
                $khas->keterangan=$request->keterangan;
                $khas->edit_by=$user->name;
                $khas->kode=$request->kode;
                $khas->tanggal=$ldate;
                $khas->save();
            $response= [
                'message'=>'khas update',
            ];
            return response()->json($response,Response::HTTP_OK);
    }

    public function destroy($id){
        $data=Khas::findOrFail($id);
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
