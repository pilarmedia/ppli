<?php

namespace App\Http\Controllers;

use App\Models\khas;
use App\Models\transaksi;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;

class transaksiController extends Controller
{
    public function index(){
        $data=transaksi::with('khas','akun','member')->get();
        $response =[
            'message' => 'succes menampilkan transaksi',
            'data' => $data
       ];
       return response()->json($response,Response::HTTP_OK);
    }

    public function store(Request $request) {
        $validator=Validator::make($request->all(),[
            'tanggal'=>'required',
            'KhasId'=>'required',
            'jenis_transaksi'=>'required',
            'AkunId'=>'required',
            'MemberId'=>'required',
            'keterangan'=>'reqired',
            'jumlah'=>'required'
       ]);
      
       if($validator->fails()){
         return response()->json($validator->errors(), 
         Response::HTTP_UNPROCESSABLE_ENTITY);
       }
       try {
             $data=array(
                'tanggal'=>'required',
                'KhasId'=>'required',
                'jenis_transaksi'=>'required',
                'AkunId'=>'required',
                'MemberId'=>'required',
                'keterangan'=>'reqired',
                'jumlah'=>'required'
              );
        $transaksi=transaksi::create($data);
        $khas=khas::where('id',$request->KhasId)->first();
        if($transaksi->keterangan == "pemasukan"){
            $khas->saldo_akhir=$khas->saldo_akhir+$transaksi->jumlah;
            $khas->save();
        }
        if($transaksi->keterangan == "pengeluaran"){
            $khas->saldo_akhir=$khas->saldo_akhir-$transaksi->jumlah;
            $khas->save();
        }
        $response= [
            'message'=>'add succes ',
            'data' => $transaksi
        ];
        return response()->json($response,Response::HTTP_CREATED);
       
       } catch (QueryException $e) {
        return response()->json([
            'message'=>"failed".$e->errorInfo
        ]);
       }    
  
 
    }

    public function show($id)  {
        // dd($id);
        $bank=bank::where('id',$id)->first();
        $response =[
            'message' => 'detail data',
            'data' => $bank
       ];
       return response()->json($response,Response::HTTP_OK);
    }

    public function update(Request $request, $id){
        // dd($request->name);
        $data=bank::findOrFail($id);
        $validator=Validator::make($request->all(),[
            'name' => 'required',
           ]);
           if($validator->fails()){
             return response()->json($validator->errors(), 
             Response::HTTP_UNPROCESSABLE_ENTITY);
           }
           try {
            $data->update($request->all());
            $response= [
                'message'=>'transaction update',
                'data' => $data
            ];
            return response()->json($response,Response::HTTP_OK);
           } catch (QueryException $e) {
            return response()->json([
                'message'=>"failed".$e->errorInfo
            ]);
           }
    }

    public function destroy($id){
        $data=bank::findOrFail($id);
        try {
            $data->delete();
        $response=[
            'message' =>'bank deleted'
        ];
        return response()->json($response,Response::HTTP_OK);
        } catch (QueryException $e) {
            return response()->json([
                'message' =>"failed".$e->errorInfo
            ]);
        }
        
    }
}
