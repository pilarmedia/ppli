<?php

namespace App\Http\Controllers;

use DateTime;
use App\Models\Wilayah;
use App\Models\IuranAnggota;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class WilayahController extends Controller
{
    public function index() {
        $wilayah=Wilayah::all();
        $response =[
            'message' => 'succes menampilkan wilayah',
            'data' => $wilayah
       ];
       return response()->json($response,Response::HTTP_OK);
    }

    
    public function store(Request $request) {
        // return $request;
        // date_default_timezone_set('Asia/Jakarta');
        $ldate = date('Y');
        // dd($ldate+1);
        $cek=Wilayah::where('HQ',1)->first();
        $validator=Validator::make($request->all(),[
            'name' => 'required|string',
            'email' => 'required|string|email',
            'kota' => 'required',
            'alamat' => 'required|string',
            'nomor'=>'required|min:6',
            // 'pic'=>'required',
            // 'jabatan'=>'required',
       ]);
     
       if($validator->fails()){
         return response()->json($validator->errors(), 
         Response::HTTP_UNPROCESSABLE_ENTITY);
       }
       if($cek != null and $request->HQ==1){
            $cek->HQ=0;
            $cek->save();
            $data=array (
                'name' => $request->name,
                'email' =>$request->email,
                'kota' =>$request->kota,
                'alamat'=>$request->alamat,
                'nomor' =>$request->nomor,
                'pic' =>$request->pic,
                'jabatan' =>$request->jabatan,
                'HQ'=>1
              );       
          $wilayah=Wilayah::create($data);
          $bulan=array('januari','februari','maret','april','mei','juni','juli','agustus','september','oktober','november','desember');
          $ldate = date('Y');
          for($i=1;$i<13;$i++){
              $result = array(
                  'bulan' => $bulan[$i-1],
                  'WilayahId' => $wilayah->id,
                  'iuran' => 100000,
                  'setoran_DPP'=>40000,
                  'tahun'=>$ldate
              ); 
              $iuran=IuranAnggota::create($result);             
             }
          $response= [
            'message'=>'add succes ',
  
           ];
          return response()->json($response,Response::HTTP_CREATED);
       } 
        try {   
            $data=array(
                'name' => $request->name,
                'email' =>$request->email,
                'kota' =>$request->kota,
                'alamat'=>$request->alamat,
                'nomor' =>$request->nomor,
                'pic' =>$request->pic,
                'jabatan' =>$request->jabatan,
                'HQ'=>($request->HQ ? true : false)
              );  
            $wilayah=Wilayah::create($data);
     
            $bulan=array('januari','februari','maret','april','mei','juni','juli','agustus','september','oktober','november','desember');
            $ldate = date('Y');
            for($i=1;$i<13;$i++){
                $result = array(
                    'bulan' => $bulan[$i-1],
                    'WilayahId' => $wilayah->id,
                    'iuran' => 100000,
                    'setoran_DPP'=>40000,
                    'tahun'=>$ldate
                ); 
                $iuran=IuranAnggota::create($result);             
               }
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
        // dd($id);
        $wilayah=Wilayah::find($id);
        $response =[
            'message' => 'detail data',
            'data' => $wilayah
       ];
       return response()->json($response,Response::HTTP_OK);
    }

    public function update(Request $request, $id){
        // dd($request->name);
        $cek=Wilayah::where('HQ',1)->first();
        $wilayah=Wilayah::findOrFail($id);
        $validator=Validator::make($request->all(),[
            'name' => 'required|string',
            'email' => 'required|string|email',
            'kota' => 'required',
            'alamat' => 'required|string',
            'nomor'=>'required|min:6',
            // 'pic'=>'required',
            // 'jabatan'=>'required',
           ]);
           if($validator->fails()){
             return response()->json($validator->errors(), 
             Response::HTTP_UNPROCESSABLE_ENTITY);
           }
           if($cek != null and $request->HQ==1){
                 $cek->HQ=0;
                 $cek->save();   
                 $wilayah->update($request->all());
                 $response= [
                      'message'=>'add succes ',
                    ];
             return response()->json($response,Response::HTTP_CREATED);
            } 
           
           try {
            $data=array(
                'name' => $request->name,
                'email' =>$request->email,
                'kota' =>$request->kota,
                'alamat'=>$request->alamat,
                'nomor' =>$request->nomor,
                'pic' =>$request->pic,
                'jabatan' =>$request->jabatan,
                'HQ'=>($request->HQ ? true : false)
              );
            $wilayah->update($data);
            $response= [
                'message'=>'transaction update',
        
            ];
            return response()->json($response,Response::HTTP_OK);
           } catch (QueryException $e) {
            return response()->json([
                'message'=>"failed".$e->errorInfo
            ]);
           }
    }

    public function destroy($id)
    {
        $wilayah=Wilayah::findOrFail($id);
        try {
            $wilayah->delete();
        $response=[
            'message' =>'wilayah deleted'
        ];
        return response()->json($response,Response::HTTP_OK);
        } catch (QueryException $e) {
            return response()->json([
                'message' =>"failed".$e->errorInfo
            ]);
        }
        
    }
}
