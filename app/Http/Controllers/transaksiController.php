<?php

namespace App\Http\Controllers;

use App\Models\akun;
use App\Models\khas;
use App\Models\transaksi;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

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
    public function selectOptionMember(){
        $data=member::all();
        $response =[
            'message' => 'succes menampilkan member',
            'data' => $data
       ];
       return response()->json($response,Response::HTTP_OK);
    }
    public function selectOptionKhas(){
        $data=khas::all();
        $response =[
            'message' => 'succes menampilkan member',
            'data' => $data
       ];
       return response()->json($response,Response::HTTP_OK);
    }
    public function selectOptionAkun(){
        $data=akun::all();
        $response =[
            'message' => 'succes menampilkan member',
            'data' => $data
       ];
       return response()->json($response,Response::HTTP_OK);
    }

    public function store(Request $request) {
        $validator=Validator::make($request->all(),[
            'tanggal'=>'required',
            'khas'=>'required',
            'jenis_transaksi'=>'required',
            'AkunId'=>'required',
            'MemberId'=>'required',
            'keterangan'=>'required',
            'jumlah'=>'required'
       ]);
      
       if($validator->fails()){
         return response()->json($validator->errors(), 
         Response::HTTP_UNPROCESSABLE_ENTITY);
       }
       try {
             $data=array(
                'tanggal'=>$request->tanggal,
                'KhasId'=>$request->khas,
                'jenis_transaksi'=>$request->jenis_transaksi,
                'AkunId'=>$request->AkunId,
                'MemberId'=>$request->MemberId,
                'keterangan'=>$request->keterangan,
                'jumlah'=>$request->jumlah,
              );
        $transaksi=transaksi::create($data);
        $khas=khas::where('id',$request->khas)->first();
        if($request->jenis_transaksi === "pemasukan"){
            // dd( $khas->saldo_akhir);
            $khas->saldo_akhir=$khas->saldo_akhir+$transaksi->jumlah;
            $khas->save();
            $response= [
                'message'=>'add succes ',
                'cek1' => $transaksi,
                'cek2' => $khas
            ];
            return response()->json($response,Response::HTTP_CREATED);
        }else{
            $khas->saldo_akhir=$khas->saldo_akhir-$transaksi->jumlah;
            $khas->save();
            $response= [
                'message'=>'add succes ',
                'cek1' => $transaksi,
                'cek2' => $khas
            ];
            return response()->json($response,Response::HTTP_CREATED);
        }
       
       } catch (QueryException $e) {
        return response()->json([
            'message'=>"failed".$e->errorInfo
        ]);
       }    
  
 
    }

    public function show($id)  {
        // dd($id);
        $data=transaksi::with('khas','akun','member')->where('id',$id)->first();
        $response =[
            'message' => 'detail data',
            'data' => $data
       ];
       return response()->json($response,Response::HTTP_OK);
    }

    public function update(Request $request, $id){
        // dd($request->name);
        $data=transaksi::findOrFail($id);
        $validator=Validator::make($request->all(),[
            'tanggal'=>'required',
            'khas'=>'required',
            'jenis_transaksi'=>'required',
            'AkunId'=>'required',
            'MemberId'=>'required',
            'keterangan'=>'required',
            'jumlah'=>'required'
       ]);
           if($validator->fails()){
             return response()->json($validator->errors(), 
             Response::HTTP_UNPROCESSABLE_ENTITY);
           }
        //    try {
            
            if($data->KhasId == $request->khas){
                // dd($data);
                $khas=khas::where('id',$data->KhasId)->first();
                // dd($khas);
                if($request->jenis_transaksi == $data->jenis_transaksi){
                    if($data->jenis_transaksi == 'pemasukan'){
                        // dd($khas->saldo_akhir);
                        $khas->saldo_akhir=$khas->saldo_akhir-$data->jumlah+$request->jumlah;
                        $khas->save();
                    }
                    else{
                        $khas->saldo_akhir=$khas->saldo_akhir+$data->jumlah-$request->jumlah;
                        $khas->save();
                    }
                }else{
                    if($data->jenis_transaksi == 'pemasukan'){
                        $khas->saldo_akhir=$khas->saldo_akhir-$data->jumlah-$request->jumlah;
                        $khas->save();
                    }else{
                        $khas->saldo_akhir=$khas->saldo_akhir+$data->jumlah+$request->jumlah;
                        $khas->save();
                    }
                }
            }else{
                $khas_lama=khas::where('id',$data->KhasId)->first();
                // dd($khas_lama);
                $khas_baru=khas::where('id',$request->khas)->first();
                if($data->jenis_transaksi == $request->jenis_transaksi){
                    if($data->jenis_transaksi == 'pemasukan'){
                        $khas_lama->saldo_akhir=$khas_lama->saldo_akhir-$data->jumlah;
                        $khas_lama->save();
                        $khas_baru->saldo_akhir=$khas_baru->saldo_akhir+$request->jumlah;
                        $khas_baru->save();
                    }else{
                        $khas_lama->saldo_akhir=$khas_lama->saldo_akhir+$data->jumlah;
                        $khas_lama->save();
                        $khas_baru->saldo_akhir=$khas_baru->saldo_akhir-$request->jumlah;
                        $khas_baru->save();
                    }
                }else{
                    if($data->jenis_transaksi == 'pemasukan'){
                        $khas_lama->saldo_akhir=$khas_lama->saldo_akhir-$data->jumlah;
                        $khas_lama->save();
                        $khas_baru->saldo_akhir=$khas_baru->saldo_akhir-$request->jumlah;
                        $khas_baru->save();
                    }else{
                        $khas_lama->saldo_akhir=$khas_lama->saldo_akhir+$data->jumlah;
                        $khas_lama->save();
                        $khas_baru->saldo_akhir=$khas_baru->saldo_akhir+$request->jumlah;
                        $khas_baru->save();
                    }
                }
                
            }
              $data->tanggal=$request->tanggal;
              $data->KhasId=$request->khas;
              $data->jenis_transaksi=$request->jenis_transaksi;
              $data->AkunId=$request->AkunId;
              $data->MemberId=$request->MemberId;
              $data->keterangan=$request->keterangan;
              $data->jumlah=$request->jumlah;
              $data->save();

            $response= [
                'message'=>'add succes ',
                'cek1' => $data,
                'cek2' => $khas_lama,
                'cek3' => $khas_baru,
                // 'cek2' => $khas_lama
            ];
            return response()->json($response,Response::HTTP_CREATED);
        //    } catch (QueryException $e) {
        //     return response()->json([
        //         'message'=>"failed".$e->errorInfo
        //     ]);
        //    }
    }

    public function destroy($id){
        $data=transaksi::findOrFail($id);
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

    public function rekap(){
        
    }
}
