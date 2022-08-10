<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\akun;
use App\Models\khas;
use App\Models\iuran;
use App\Models\member;
use App\Models\laporan;
use App\Models\transaksi;
use App\Models\iuranAnggota;
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
    public function selectOptionIuran (Request $request){
        $wilayah=member::where('id',$request->MemberId)->first()['WilayahId'];
        $jumlah=0;
        if($request->akun=='1'){
            $jumlah=iuranAnggota::where('WilayahId',$wilayah)->first()['iuran'];
            return response()->json($jumlah, 200); 
        }
        elseif($request->akun=='2'){
            $jumlah=iuranAnggota::where('WilayahId',$wilayah)->first()['setoran_DPP'];
            return response()->json($jumlah, 200); 
        }else{
            return response()->json($jumlah, 200);
        }        
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
        $bulan1=$request->tanggal;
        $tes=date_parse($bulan1);
        $khas=khas::where('id',$request->KhasId)->first();

        if($request->jenis_transaksi === "pemasukan"){
            if ($request->AkunId=='2'){
                if($tes['month']=='1'){
                    $iuranAnggota=iuran::where('memberId',$request->MemberId)->where('bulan','januari')->first();
                    $iuranAnggota->status='lunas';
                    $iuranAnggota->jumlah=$request->jumlah;
                    $iuranAnggota->save();
                            
                    $khas->saldo_akhir=$khas->saldo_akhir+$transaksi->jumlah;
                    $khas->save();
                    $data2=array(
                        'KhasId'=>$khas->id,
                        'debit'=>$request->jumlah,
                        'kredit'=>0,
                        'saldo_akhir'=>$khas->saldo_akhir
                    );
                    //   dd($data2);
                    $laporan=laporan::create($data2);
                    $response= [
                        'message'=>'add succes ',
                    ];
                    return response()->json($response,Response::HTTP_CREATED);
                }
                elseif($tes['month']=='2'){
                    $iuranAnggota=iuran::where('memberId',$request->MemberId)->where('bulan','februari')->first();
                    $iuranAnggota->status='lunas';
                    $iuranAnggota->jumlah=$request->jumlah;
                    $iuranAnggota->save();
                            
                    $khas->saldo_akhir=$khas->saldo_akhir+$transaksi->jumlah;
                    $khas->save();
                    $data2=array(
                        'KhasId'=>$khas->id,
                        'debit'=>$request->jumlah,
                        'kredit'=>0,
                        'saldo_akhir'=>$khas->saldo_akhir
                    );
                    //   dd($data2);
                    $laporan=laporan::create($data2);
                    $response= [
                        'message'=>'add succes ',
                    ];
                    return response()->json($response,Response::HTTP_CREATED);
                }
                elseif($tes['month']=='3'){
                    $iuranAnggota=iuran::where('memberId',$request->MemberId)->where('bulan','maret')->first();
                    $iuranAnggota->status='lunas';
                    $iuranAnggota->jumlah=$request->jumlah;
                    $iuranAnggota->save();        
                    $khas->saldo_akhir=$khas->saldo_akhir+$transaksi->jumlah;
                    $khas->save();
                    $data2=array(
                        'KhasId'=>$khas->id,
                        'debit'=>$request->jumlah,
                        'kredit'=>0,
                        'saldo_akhir'=>$khas->saldo_akhir
                    );
                    //   dd($data2);
                    $laporan=laporan::create($data2);
                    $response= [
                        'message'=>'add succes ',
                    ];
                    return response()->json($response,Response::HTTP_CREATED);
                }
                elseif($tes['month']=='4'){
                    $iuranAnggota=iuran::where('memberId',$request->MemberId)->where('bulan','april')->first();
                    $iuranAnggota->status='lunas';
                    $iuranAnggota->jumlah=$request->jumlah;
                    $iuranAnggota->save();
                            
                    $khas->saldo_akhir=$khas->saldo_akhir+$transaksi->jumlah;
                    $khas->save();
                    $data2=array(
                        'KhasId'=>$khas->id,
                        'debit'=>$request->jumlah,
                        'kredit'=>0,
                        'saldo_akhir'=>$khas->saldo_akhir
                    );
                    //   dd($data2);
                    $laporan=laporan::create($data2);
                    $response= [
                        'message'=>'add succes ',
                    ];
                    return response()->json($response,Response::HTTP_CREATED);
                }
                elseif($tes['month']=='5'){
                    $iuranAnggota=iuran::where('memberId',$request->MemberId)->where('bulan','mei')->first();
                    $iuranAnggota->status='lunas';
                    $iuranAnggota->jumlah=$request->jumlah;
                    $iuranAnggota->save();
                            
                    $khas->saldo_akhir=$khas->saldo_akhir+$transaksi->jumlah;
                    $khas->save();
                    $data2=array(
                        'KhasId'=>$khas->id,
                        'debit'=>$request->jumlah,
                        'kredit'=>0,
                        'saldo_akhir'=>$khas->saldo_akhir
                    );
                    //   dd($data2);
                    $laporan=laporan::create($data2);
                    $response= [
                        'message'=>'add succes ',
                    ];
                    return response()->json($response,Response::HTTP_CREATED);
                }
                elseif($tes['month']=='6'){
                    $iuranAnggota=iuran::where('memberId',$request->MemberId)->where('bulan','juni')->first();
                    $iuranAnggota->status='lunas';
                    $iuranAnggota->jumlah=$request->jumlah;
                    $iuranAnggota->save();
                            
                    $khas->saldo_akhir=$khas->saldo_akhir+$transaksi->jumlah;
                    $khas->save();
                    $data2=array(
                        'KhasId'=>$khas->id,
                        'debit'=>$request->jumlah,
                        'kredit'=>0,
                        'saldo_akhir'=>$khas->saldo_akhir
                    );
                    //   dd($data2);
                    $laporan=laporan::create($data2);
                    $response= [
                        'message'=>'add succes ',
                    ];
                    return response()->json($response,Response::HTTP_CREATED);
                }
                elseif($tes['month']=='7'){
                    $iuranAnggota=iuran::where('memberId',$request->MemberId)->where('bulan','juli')->first();
                    $iuranAnggota->status='lunas';
                    $iuranAnggota->jumlah=$request->jumlah;
                    $iuranAnggota->save();
                            
                    $khas->saldo_akhir=$khas->saldo_akhir+$transaksi->jumlah;
                    $khas->save();
                    $data2=array(
                        'KhasId'=>$khas->id,
                        'debit'=>$request->jumlah,
                        'kredit'=>0,
                        'saldo_akhir'=>$khas->saldo_akhir
                    );
                    //   dd($data2);
                    $laporan=laporan::create($data2);
                    $response= [
                        'message'=>'add succes ',
                    ];
                    return response()->json($response,Response::HTTP_CREATED);
                }
                elseif($tes['month']=='8'){
                    $iuranAnggota=iuran::where('memberId',$request->MemberId)->where('bulan','agustus')->first();
                    $iuranAnggota->status='lunas';
                    $iuranAnggota->jumlah=$request->jumlah;
                    $iuranAnggota->save();
                            
                    $khas->saldo_akhir=$khas->saldo_akhir+$transaksi->jumlah;
                    $khas->save();
                    $data2=array(
                        'KhasId'=>$khas->id,
                        'debit'=>$request->jumlah,
                        'kredit'=>0,
                        'saldo_akhir'=>$khas->saldo_akhir
                    );
                    //   dd($data2);
                    $laporan=laporan::create($data2);
                    $response= [
                        'message'=>'add succes ',
                    ];
                    return response()->json($response,Response::HTTP_CREATED);
                }
                elseif($tes['month']=='9'){
                    $iuranAnggota=iuran::where('memberId',$request->MemberId)->where('bulan','september')->first();
                    $iuranAnggota->status='lunas';
                    $iuranAnggota->jumlah=$request->jumlah;
                    $iuranAnggota->save();
                            
                    $khas->saldo_akhir=$khas->saldo_akhir+$transaksi->jumlah;
                    $khas->save();
                    $data2=array(
                        'KhasId'=>$khas->id,
                        'debit'=>$request->jumlah,
                        'kredit'=>0,
                        'saldo_akhir'=>$khas->saldo_akhir
                    );
                    //   dd($data2);
                    $laporan=laporan::create($data2);
                    $response= [
                        'message'=>'add succes ',
                    ];
                    return response()->json($response,Response::HTTP_CREATED);
                }
                elseif($tes['month']=='10'){
                    $iuranAnggota=iuran::where('memberId',$request->MemberId)->where('bulan','oktober')->first();
                    $iuranAnggota->status='lunas';
                    $iuranAnggota->jumlah=$request->jumlah;
                    $iuranAnggota->save();
                            
                    $khas->saldo_akhir=$khas->saldo_akhir+$transaksi->jumlah;
                    $khas->save();
                    $data2=array(
                        'KhasId'=>$khas->id,
                        'debit'=>$request->jumlah,
                        'kredit'=>0,
                        'saldo_akhir'=>$khas->saldo_akhir
                    );
                    //   dd($data2);
                    $laporan=laporan::create($data2);
                    $response= [
                        'message'=>'add succes ',
                    ];
                    return response()->json($response,Response::HTTP_CREATED);
                }
                elseif($tes['month']=='11'){
                    $iuranAnggota=iuran::where('memberId',$request->MemberId)->where('bulan','november')->first();
                    $iuranAnggota->status='lunas';
                    $iuranAnggota->jumlah=$request->jumlah;
                    $iuranAnggota->save();
                            
                    $khas->saldo_akhir=$khas->saldo_akhir+$transaksi->jumlah;
                    $khas->save();
                    $data2=array(
                        'KhasId'=>$khas->id,
                        'debit'=>$request->jumlah,
                        'kredit'=>0,
                        'saldo_akhir'=>$khas->saldo_akhir
                    );
                    //   dd($data2);
                    $laporan=laporan::create($data2);
                    $response= [
                        'message'=>'add succes ',
                    ];
                    return response()->json($response,Response::HTTP_CREATED);
                }
                elseif($tes['month']=='12'){
                    $iuranAnggota=iuran::where('memberId',$request->MemberId)->where('bulan','desember')->first();
                    $iuranAnggota->status='lunas';
                    $iuranAnggota->jumlah=$request->jumlah;
                    $iuranAnggota->save();
                            
                    $khas->saldo_akhir=$khas->saldo_akhir+$transaksi->jumlah;
                    $khas->save();
                    $data2=array(
                        'KhasId'=>$khas->id,
                        'debit'=>$request->jumlah,
                        'kredit'=>0,
                        'saldo_akhir'=>$khas->saldo_akhir
                    );
                    //   dd($data2);
                    $laporan=laporan::create($data2);
                    $response= [
                        'message'=>'add succes ',
                    ];
                    return response()->json($response,Response::HTTP_CREATED);
                }
            }else{
                $khas->saldo_akhir=$khas->saldo_akhir+$transaksi->jumlah;
                $khas->save();
                $data2=array(
                    'KhasId'=>$khas->id,
                    'debit'=>$request->jumlah,
                    'kredit'=>0,
                    'saldo_akhir'=>$khas->saldo_akhir
                );
                //   dd($data2);
                $laporan=laporan::create($data2);
                $response= [
                    'message'=>'add succes ',
                ];
                return response()->json($response,Response::HTTP_CREATED);
            }

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
    public function bulan($bulan){
            $bahasa = array (
                1 =>   'januari',
                'februari',
                'maret',
                'april',
                'mei',
                'juni',
                'juli',
                'agustus',
                'september',
                'oktober',
                'november',
                'desember'
            );
            return $bahasa[$bulan];
    }
    public function update(Request $request, $id){
        // dd($request->name);
        // $bulan2=self::bulan(2);
        // dd($bulan2);
                           
        $data=transaksi::findOrFail($id);
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
            
            if($data->KhasId == $request->KhasId){
                // dd($data);
                $khas=khas::where('id',$data->KhasId)->first();
                $laporan=laporan::where('KhasId',$khas->id)->first();
                $bulan1=$data->tanggal;
                $tes=date_parse($bulan1);
                $bulan=$tes['month'];
                $bulan2=self::bulan($bulan);
                // dd($khas);
                if($request->jenis_transaksi == $data->jenis_transaksi){
                    if($data->jenis_transaksi == 'pemasukan'){
                        // dd($request->AkunId);
                        if($data->AkunId =='2' && $request->AkunId !='2'){
                           
                            $iuranAnggota=iuran::where('memberId',$request->MemberId)->where('bulan',$bulan2)->first();
                            $iuranAnggota->status='belum lunas';
                            $iuranAnggota->jumlah=0;
                            $iuranAnggota->save();

                            $khas->saldo_akhir=$khas->saldo_akhir-$data->jumlah+$request->jumlah;
                            $khas->save();
                            $laporan->debit=$request->jumlah;
                            $laporan->saldo_akhir=$khas->saldo_akhir;
                            $laporan->save();
                           
                            $data->tanggal=$request->tanggal;
                            $data->KhasId=$request->KhasId;
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
                           
                        }elseif($data->AkunId !='2' && $request->AkunId =='2'){
                            $iuranAnggota=iuran::where('memberId',$request->MemberId)->where('bulan',$bulan2)->first();
                                    $iuranAnggota->status='lunas';
                                    $iuranAnggota->jumlah=$request->jumlah;
                                    $iuranAnggota->save();

                                    $khas->saldo_akhir=$khas->saldo_akhir-$data->jumlah+$request->jumlah;
                                    $khas->save();
                                    $laporan->debit=$request->jumlah;
                                    $laporan->saldo_akhir=$khas->saldo_akhir;
                                    $laporan->save();
                                     
                                    $data->tanggal=$request->tanggal;
                                    $data->KhasId=$request->KhasId;
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
                        }else{
                            $khas->saldo_akhir=$khas->saldo_akhir-$data->jumlah+$request->jumlah;
                            $khas->save();
                            $laporan->debit=$request->jumlah;
                            $laporan->saldo_akhir=$khas->saldo_akhir;
                            $laporan->save();
                             
                            $data->tanggal=$request->tanggal;
                            $data->KhasId=$request->KhasId;
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
                        }
                    }
                    else{
                        $khas->saldo_akhir=$khas->saldo_akhir+$data->jumlah-$request->jumlah;
                        $khas->save();
                        $laporan->kredit=$request->jumlah;
                        $laporan->saldo_akhir=$khas->saldo_akhir;
                        $laporan->save();
                         
                        $data->tanggal=$request->tanggal;
                        $data->KhasId=$request->KhasId;
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
                    }
                }else{
                    if($data->jenis_transaksi == 'pemasukan'){
                        if ($data->AkunId=='1' && $request->AkunId !='1'){

                            $iuranAnggota=iuran::where('memberId',$request->MemberId)->where('bulan',$bulan2)->first();
                            $iuranAnggota->status='belum lunas';
                            $iuranAnggota->jumlah=0;
                            $iuranAnggota->save();
                            
                            $khas->saldo_akhir=$khas->saldo_akhir-$data->jumlah-$request->jumlah;
                            $khas->save();
                            $laporan->kredit=$request->jumlah;
                            $laporan->debit=0;
                            $laporan->saldo_akhir=$khas->saldo_akhir;
                            $laporan->save();
                             
                            $data->tanggal=$request->tanggal;
                            $data->KhasId=$request->KhasId;
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
                            
                                
                        }elseif($data->AkunId !='1' && $request->AkunId =='1'){

                            $iuranAnggota=iuran::where('memberId',$request->MemberId)->where('bulan',$bulan2)->first();
                            $iuranAnggota->status='lunas';
                            $iuranAnggota->save();
                            
                            $khas->saldo_akhir=$khas->saldo_akhir-$data->jumlah-$request->jumlah;
                            $khas->save();
                            $laporan->kredit=$request->jumlah;
                            $laporan->debit=0;
                            $laporan->saldo_akhir=$khas->saldo_akhir;
                            $laporan->save();
                            $data->tanggal=$request->tanggal;
                            $data->KhasId=$request->KhasId;
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
                        
                        }else{
                            $khas->saldo_akhir=$khas->saldo_akhir-$data->jumlah-$request->jumlah;
                            $khas->save();
                            $laporan->kredit=$request->jumlah;
                            $laporan->debit=0;
                            $laporan->saldo_akhir=$khas->saldo_akhir;
                            $laporan->save();

                            $data->tanggal=$request->tanggal;
                            $data->KhasId=$request->KhasId;
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
                        }
                       
                    }else{
                        $khas->saldo_akhir=$khas->saldo_akhir+$data->jumlah+$request->jumlah;
                        $khas->save();
                        $laporan->debit=$request->jumlah;
                        $laporan->kredit=0;
                        $laporan->saldo_akhir=$khas->saldo_akhir;
                        $laporan->save();

                        $data->tanggal=$request->tanggal;
                        $data->KhasId=$request->KhasId;
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
                    }
                }
            }else{
                $khas_lama=khas::where('id',$data->KhasId)->first();
                $laporan_lama=laporan::where('KhasId',$khas_lama->id)->first();
                $laporan=laporan::where('id', $laporan_lama->id)->first();
                $laporan->KhasId=$request->KhasId;
                $khas_baru=khas::where('id',$request->KhasId)->first();
                if($data->jenis_transaksi == $request->jenis_transaksi){
                    if($data->jenis_transaksi == 'pemasukan'){
                        $khas_lama->saldo_akhir=$khas_lama->saldo_akhir-$data->jumlah;
                        $khas_lama->save();
                        $khas_baru->saldo_akhir=$khas_baru->saldo_akhir+$request->jumlah;
                        $khas_baru->save();
                        $laporan->debit=$request->jumlah;
                        $laporan->saldo_akhir=$khas_baru->saldo_akhir;
                        $laporan->save();
                        $data->tanggal=$request->tanggal;
                        $data->KhasId=$request->KhasId;
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
                    }else{
                        $khas_lama->saldo_akhir=$khas_lama->saldo_akhir+$data->jumlah;
                        $khas_lama->save();
                        $khas_baru->saldo_akhir=$khas_baru->saldo_akhir-$request->jumlah;
                        $khas_baru->save();
                        $laporan->kredit=$request->jumlah;
                        $laporan->saldo_akhir=$khas_baru->saldo_akhir;
                        $laporan->save();
                        $data->tanggal=$request->tanggal;
                        $data->KhasId=$request->KhasId;
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
                        $data->tanggal=$request->tanggal;
                        $data->KhasId=$request->KhasId;
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
                    }else{
                        $khas_lama->saldo_akhir=$khas_lama->saldo_akhir+$data->jumlah;
                        $khas_lama->save();
                        $khas_baru->saldo_akhir=$khas_baru->saldo_akhir+$request->jumlah;
                        $khas_baru->save();
                        $laporan->debit=$request->jumlah;
                        $laporan->kredit=0;
                        $laporan->saldo_akhir=$khas_baru->saldo_akhir;
                        $laporan->save();
                        $data->tanggal=$request->tanggal;
                        $data->KhasId=$request->KhasId;
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

                    }
                }
                
            }
              
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
        $response =[
            'message' => 'detail data',
            'data' => $data
       ];
       return response()->json($response,Response::HTTP_OK);
    }
    public function selectOptionTahun (){

       $tes= khas::all()->groupBy(function($date) {
            return Carbon::parse($date->created_at)->format('Y');
        })->sortBy('created_at');

        
        $data=array();
        foreach($tes as $key=>$item){
            $data[]=$key;
        }

       return response()->json($data, 200);
    }
    public function rekap(Request $request){
        // dd('a');
        $data=array('januari','februari','maret','april','mei','juni','juli','agustus','september','oktober','november','desember');
        // dd($request->tahun);
        // $result=array();
        for($i=1;$i<13;$i++){
         $debit = DB::table('laporans')
         ->whereYear('created_at',$request->tahun)
         ->whereMonth('created_at',$i)
         ->get()->sum('saldo_akhir');
        //  dd($debit);
         $kredit = DB::table('laporans')
         ->whereYear('created_at', $request->tahun)
         ->whereMonth('created_at',$i)
         ->get()->sum('kredit');
         $result[] = array(
             'bulan' => $data[$i-1],
             'debit' => $debit,
             'kredit' => $kredit
         );
        
        }
        $response =[
            'message' => 'detail data',
            'data' => $result
       ];
       return response()->json($response,Response::HTTP_OK);
    }
    public function jenis_transaksi(Request $request){
        $data=akun::where('kategori_akun',$request->jenis_transaksi)->get();
        return response()->json($data, 200);
    }
    public function memberTransaksi($id){
        $data=transaksi::where('MemberId',$id)->get();
        return response()->json($data, 200);
    }
}