<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\khas;
use App\Models\iuran;
use App\Models\member;
use App\Models\transaksi;
use App\Models\iuranAnggota;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class iuranController extends Controller
{
    public function index (Request $request){
        // dd('a');
        $data=iuran::with('member')->where('tahun',$request->tahun)->where('bulan',$request->bulan)->get();
        return response()->json($data, 200);
    }
    public function updateShow(Request $request,$id){
        $data=iuran::where('tahun',$request->tahun)->where('memberId',$id)->get();
        return response()->json($data, 200);
    }

    public function update(Request $request,$id){
        $iuran=iuran::find($id)->first();
        $member=member::find($iuran->memberId);
        $iuranAnggota=iuranAnggota::where('WilayahId',$member->WilayahId)->first();
        
        $validator=Validator::make($request->all(),[
            'tanggal_bayar'=>'required',
            'status'=>'required'
         ]);
           if($validator->fails()){
             return response()->json($validator->errors(), 
             Response::HTTP_UNPROCESSABLE_ENTITY);
           }
           try {
            if ($request->status == 'lunas' && $iuran->status !='lunas'){
                $data=array(
                    'tanggal'=>$request->tanggal_bayar,
                    'KhasId'=>1,
                    'jenis_transaksi'=>'pemasukan',
                    'AkunId'=>2,
                    'MemberId'=>$member->id,
                    'keterangan'=>'iuran',
                    'jumlah'=>$iuranAnggota->iuran,
                  );
            $transaksi=transaksi::create($data);
            $khas=khas::find(1);
            $khas->saldo_akhir=$iuranAnggota->iuran+$khas->saldo_akhir;
            $khas->save();
                $data2=array(
                    'KhasId'=>1,
                    'debit'=>$iuranAnggota->iuran,
                    'kredit'=>0,
                    'saldo_akhir'=>$khas->saldo_akhir
                );
                //   dd($data2);
                $laporan=laporan::create($data2);
                $iuran->tanggal_bayar=$request->tanggal_bayar;
                $iuran->status=$request->status;
                $iuran->jumlah=$iuranAnggota->iuran;
                $iuran->save();
               
                return response()->json('update berhasil', 200);
            } else{
                
            $transaksi=transaksi::where('MemberId',$member->id)->first();
            $transaksi->delete();
            $khas=khas::find(1);
            $khas->saldo_akhir=$khas->saldo_akhir-$iuranAnggota->iuran;
            $khas->save();
                $data2=array(
                    'KhasId'=>1,
                    'debit'=>0,
                    'kredit'=>$iuranAnggota->iuran,
                    'saldo_akhir'=>$khas->saldo_akhir
                );
                //   dd($data2);
                $laporan=laporan::create($data2);
                $iuran->tanggal_bayar=$request->tanggal_bayar;
                $iuran->status=$request->status;
                $iuran->jumlah=$iuranAnggota->jumlah;
                $iuran->save();
               
                return response()->json('update berhasil', 200);

            }
        
           } catch (QueryException $e) {
            return response()->json([
                'message'=>"failed".$e->errorInfo
            ]);
           }
          
    }
    public function selectOption(){
        $tes= iuran::all()->groupBy(function($date) {
            return Carbon::parse($date->created_at)->format('Y');
        })->sortBy('created_at');
        $data=array();
        foreach($tes as $key=>$item){
            $data[]=$key;
        }
       return response()->json($data, 200); 
    }
    public function selectOptionBulan(){
        $data=array('januari','februari','maret','april','mei','juni','juli','agustus','september','oktober','november','desember');
        return response()->json($data, 200); 

    }
    public function showUpdate($id){
        $data=iuran::where('id',$id)->first();
        return response()->json($data, 200);
    }
}
