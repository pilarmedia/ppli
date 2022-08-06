<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\akun;
use App\Models\khas;
use App\Models\member;
use App\Models\laporan;
use App\Models\transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class transaksiController extends Controller
{
    public function index(){
        // dd('b');
        $data=transaksi::with('khas','akun','member')->get();
        // dd('a');
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
            'KhasId'=>'required',
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
                'KhasId'=>$request->KhasId,
                'jenis_transaksi'=>$request->jenis_transaksi,
                'AkunId'=>$request->AkunId,
                'MemberId'=>$request->MemberId,
                'keterangan'=>$request->keterangan,
                'jumlah'=>$request->jumlah,
              );
        $transaksi=transaksi::create($data);
        $khas=khas::where('id',$request->KhasId)->first();

        if($request->jenis_transaksi === "pemasukan"){
            // dd( $khas->saldo_akhir);

            $khas->saldo_akhir=$khas->saldo_akhir+$transaksi->jumlah;
            $khas->save();
            $data2=array(
                'KhasId'=>$khas->id,
                'debit'=>$request->jumlah,
                'kredit'=>0,
                'saldo_akhir'=>$request->saldo_awal
              );
            //   dd($data2);
              $laporan=laporan::create($data2);
            $response= [
                'message'=>'add succes ',
                'cek1' => $transaksi,
                'cek2' => $khas
            ];
            return response()->json($response,Response::HTTP_CREATED);
        }else{
            $khas->saldo_akhir=$khas->saldo_akhir-$transaksi->jumlah;
            $khas->save();
            $data2=array(
                'KhasId'=>$khas->id,
                'debit'=>0,
                'kredit'=>$request->jumlah,
                'saldo_akhir'=>$khas->saldo_akhir
              );
            //   dd($data2);
              $laporan=laporan::create($data2);
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
        $data=transaksi::with('akun','member','khas')->where('id',$id)->first();
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
           try {
            
            if($data->KhasId == $request->khas){
                // dd($data);
                $khas=khas::where('id',$data->KhasId)->first();
                $laporan=laporan::where('KhasId',$khas->id)->first();
                // dd($khas);
                if($request->jenis_transaksi == $data->jenis_transaksi){
                    if($data->jenis_transaksi == 'pemasukan'){
                        // dd($khas->saldo_akhir);
                        $khas->saldo_akhir=$khas->saldo_akhir-$data->jumlah+$request->jumlah;
                        $khas->save();
                        $laporan->debit=$request->jumlah;
                        $laporan->saldo_akhir=$khas->saldo_akhir;
                        $laporan->save();
                        
                    }
                    else{
                        $khas->saldo_akhir=$khas->saldo_akhir+$data->jumlah-$request->jumlah;
                        $khas->save();
                        $laporan->kredit=$request->jumlah;
                        $laporan->saldo_akhir=$khas->saldo_akhir;
                        $laporan->save();
                    }
                }else{
                    if($data->jenis_transaksi == 'pemasukan'){
                        $khas->saldo_akhir=$khas->saldo_akhir-$data->jumlah-$request->jumlah;
                        $khas->save();
                        $laporan->kredit=$request->jumlah;
                        $laporan->debit=0;
                        $laporan->saldo_akhir=$khas->saldo_akhir;
                        $laporan->save();
                    }else{
                        $khas->saldo_akhir=$khas->saldo_akhir+$data->jumlah+$request->jumlah;
                        $khas->save();
                        $laporan->debit=$request->jumlah;
                        $laporan->kredit=0;
                        $laporan->saldo_akhir=$khas->saldo_akhir;
                        $laporan->save();
                    }
                }
            }else{
                $khas_lama=khas::where('id',$data->KhasId)->first();
                $laporan_lama=laporan::where('KhasId',$khas_lama->id)->first();
                $laporan=laporan::where('id', $laporan_lama->id)->first();
                $laporan->KhasId=$request->khas;
                $khas_baru=khas::where('id',$request->khas)->first();
                if($data->jenis_transaksi == $request->jenis_transaksi){
                    if($data->jenis_transaksi == 'pemasukan'){
                        $khas_lama->saldo_akhir=$khas_lama->saldo_akhir-$data->jumlah;
                        $khas_lama->save();
                        $khas_baru->saldo_akhir=$khas_baru->saldo_akhir+$request->jumlah;
                        $khas_baru->save();
                        $laporan->debit=$request->jumlah;
                        $laporan->saldo_akhir=$khas_baru->saldo_akhir;
                        $laporan->save();
                    }else{
                        $khas_lama->saldo_akhir=$khas_lama->saldo_akhir+$data->jumlah;
                        $khas_lama->save();
                        $khas_baru->saldo_akhir=$khas_baru->saldo_akhir-$request->jumlah;
                        $khas_baru->save();
                        $laporan->kredit=$request->jumlah;
                        $laporan->saldo_akhir=$khas_baru->saldo_akhir;
                        $laporan->save();
                    }
                }else{
                    if($data->jenis_transaksi == 'pemasukan'){
                        $khas_lama->saldo_akhir=$khas_lama->saldo_akhir-$data->jumlah;
                        $khas_lama->save();
                        $khas_baru->saldo_akhir=$khas_baru->saldo_akhir-$request->jumlah;
                        $khas_baru->save();
                        $laporan->kredit=$request->jumlah;
                        $laporan->debit=0;
                        $laporan->saldo_akhir=$khas_baru->saldo_akhir;
                        $laporan->save();
                    }else{
                        $khas_lama->saldo_akhir=$khas_lama->saldo_akhir+$data->jumlah;
                        $khas_lama->save();
                        $khas_baru->saldo_akhir=$khas_baru->saldo_akhir+$request->jumlah;
                        $khas_baru->save();
                        $laporan->debit=$request->jumlah;
                        $laporan->kredit=0;
                        $laporan->saldo_akhir=$khas_baru->saldo_akhir;
                        $laporan->save();
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
                'message'=>'update succes ',
                // 'cek2' => $khas_lama
            ];
            return response()->json($response,Response::HTTP_CREATED);
           } catch (QueryException $e) {
            return response()->json([
                'message'=>"failed".$e->errorInfo
            ]);
           }
    }

    public function destroy($id){
        $data=transaksi::findOrFail($id);
        $khas=khas::where('id',$data->KhasId)->first();
        try {
            $data->delete();
            if($data->jenis_transaksi == 'pemasukan'){
                $khas->saldo_akhir=$khas->saldo_akhir-$data->jumlah;
                $khas->save();
            }else{
                $khas->saldo_akhir=$khas->saldo_akhir+$data->jumlah;
                $khas->save();
            }
           
        $response=[
            'message' =>'transaksi deleted'
        ];
        return response()->json($response,Response::HTTP_OK);
        } catch (QueryException $e) {
            return response()->json([
                'message' =>"failed".$e->errorInfo
            ]);
        }
        
    }
    public function laporan(){
        // dd('a');
        $data=laporan::with('khas')->get();
        return response()->json($data,200);
    }
    public function selectOptionTahun (){

    //    $tes= khas::all()->groupBy(function($date) {
    //         return Carbon::parse($date->created_at)->format('Y-m');
    //     })->sortBy('created_at');

        
    //     $data=array();
    //     foreach($tes as $key=>$item){
    //         $data[]=$key;
    //     }
    $data=array('januari','februari','maret','april','mei','juni','juli','agustus','september','oktober','november','desember');
   for($i=1;$i<13;$i++){
    $tes = DB::table('khas')
    ->whereYear('created_at', '2022')
    ->whereMonth('created_at',$i)
    ->get()->sum('saldo_akhir');
    $result[] = [
        'bulan' => $data[$i-1],
        'data' => $tes
    ];
   }
   $tes= khas::all()->groupBy(function($date) {
            return Carbon::parse($date->created_at)->format('Y-m');
        })->sortBy('created_at');
//    dd($tes);
$data=array();
    foreach($tes as $key=>$item){
        $data[]=$key;
    }

       return response()->json($tes, 200);
    }
}
