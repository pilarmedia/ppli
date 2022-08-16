<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Wilayah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class MemberController extends Controller
{
    // public function index()
    // {
    //     $data=member::with('wilayah','Cities','CompanyIndustry','provinsi')->get();
    //     $response =[
    //         'message' => 'succes menampilkan member',
    //         'data' => $data
    //    ];
    //    return response()->json($response,Response::HTTP_OK);
    // }

    public function show($id)
    {
        // dd($id);
        $data=Member::where('id',$id)->with('wilayah','Cities','CompanyIndustry','provinsi')->first();
        $response =[
            'message' => 'detail data',
            'data' => $data
       ];
       return response()->json($response,Response::HTTP_OK);
    }

    public function update(Request $request,$id){
    
    
        $data=Member::where('id',$id)->with('wilayah','Cities','CompanyIndustry','provinsi')->first();
        $data->name=$request->name;
        $data->email=$request->email;
        $data->NamaPerushaan=$request->NamaPerushaan;
        $data->PhoneNumber=$request->PhoneNumber;
        $data->status=$request->status;
        $data->alamat=$request->alamat;
        $data->BentukBadanUsaha=$request->BentukBadanUsaha;
        $data->save();
        return response()->json($data, 200);
    }

    public function MemberWilayah(Request $request){

        if($request->wilayah ==='0'){
            $data=Member::with('wilayah','Cities','CompanyIndustry','provinsi')->get();
            $cek=auth()->user();
             $cekRegister=$cek->WilayahId;
             $cekWilayah=Wilayah::where('id',$cekRegister)->first();
             $regis=array();
            foreach ($data as $item) {
                $conidition = true;
                
                if($cek->roles == 'admin' || $cekWilayah->HQ == '1' ){
                    $regis[] = [
                        'id'=>$item->id,
                        'name'=>$item->name,
                        'wilayah'=>$item->wilayah->name,
                        'email'=>$item->email,
                        'PhoneNumber'=>$item->PhoneNumber,
                        'cekWilayah'=>true
                    ];                   
                }
                else{
                if ($item->WilayahId == $cekRegister) {
                        $regis[] = [
                            'id'=>$item->id,
                            'name'=>$item->name,
                            'wilayah'=>$item->wilayah->name,
                            'status'=>$item->status,
                            'email'=>$item->email,
                            'PhoneNumber'=>$item->PhoneNumber,
                            'cekWilayah'=>true
                        ];
                        $conidition = false;
                        continue;
                    }
                
                if ($conidition != false) {
                    $regis[] = [
                        'id'=>$item->id,
                        'name'=>$item->name,
                        'wilayah'=>$item->wilayah->name,
                        'email'=>$item->email,
                        'PhoneNumber'=>$item->PhoneNumber,
                        'status'=>$item->status,
                        'cekWilayah'=>false
                    ];
                }
                }
            }
            $response =[
                'message' => 'succes menampilkan member',
                'data' => $regis
           ];
           return response()->json($response,Response::HTTP_OK);
        } else{
        // $wilayah=Wilayah::where('id',$request->wilayah)->first();
                $data=Member::where('WilayahId',$request->wilayah)->with('Wilayah','Cities','CompanyIndustry','provinsi')->get();
                $cek=auth()->user();
                $cekRegister=$cek->WilayahId;
                $cekWilayah=Wilayah::where('id',$cekRegister)->first();
                $regis=array();
            foreach ($data as $item) {
                $conidition = true;
                
                if($cek->roles == 'admin' || $cekWilayah->HQ == '1' ){
                    $regis[] = [
                        'id'=>$item->id,
                        'name'=>$item->name,
                        'wilayah'=>$item->wilayah->name,
                        'email'=>$item->email,
                        'PhoneNumber'=>$item->PhoneNumber,
                        'cekWilayah'=>true
                    ];                   
                }
                else{
                if ($item->WilayahId == $cekRegister) {
                        $regis[] = [
                            'id'=>$item->id,
                            'name'=>$item->name,
                            'wilayah'=>$item->wilayah->name,
                            'status'=>$item->status,
                            'email'=>$item->email,
                            'PhoneNumber'=>$item->PhoneNumber,
                            'cekWilayah'=>true
                        ];
                        $conidition = false;
                        continue;
                    }
                
                if ($conidition != false) {
                    $regis[] = [
                        'id'=>$item->id,
                        'name'=>$item->name,
                        'wilayah'=>$item->wilayah->name,
                        'email'=>$item->email,
                        'PhoneNumber'=>$item->PhoneNumber,
                        'status'=>$item->status,
                        'cekWilayah'=>false
                    ];
                }
                }
            }
            $response =[
                'message' => 'succes menampilkan member',
                'data' => $regis
            ];
      return response()->json($response,Response::HTTP_OK);
         
        }
     }
     public function gambar(Request $request,$id){
        $member=Member::find($id);
        $imageName = time().'.'.$request->gambar->getClientOriginalName();
        $gambar=Storage::putFileAs('public/gambar',$request->gambar,$imageName);
        $tes='/storage/gambar/'. $imageName;
        // dd($nama);
        $member->gambar=$tes;
        $member->save();
        return response()->json('berhasil upload gambar', 200);
     }
     public function getGambar($id){
        $member=Member::find($id);
        $path = $member->gambar;
        // return $path;
        return response()->json($path, 200 );
     }
     public function index(){
        $data=Member::with('wilayah','Cities','CompanyIndustry','provinsi')->get();
        $cek=auth()->user();
        // dd($data->wilayah);
        $cekRegister=$cek->WilayahId;
        $cekWilayah=Wilayah::where('id',$cekRegister)->first();
        // $cekStatus=register::where('email',$cek->email)->first();
        $user=array();
        // dd($cekHQ);
        // dd($cekStatus);
        foreach ($data as $item) {
            $conidition = true;
            
            if(($cek->roles == 'admin' ) || ($cekWilayah->HQ == '1') ){
                $regis[] = [
                    'id'=>$item->id,
                    'name'=>$item->name,
                    'nama_perusahaan'=>$item->NamaPerushaan,
                    'wilayah'=>$item->wilayah->name,
                    'status'=>$item->status,
                    'cekWilayah'=>false
                ];
            } else{
            if ($item->WilayahId == $cekRegister) {
                    $nilai=false;
                    if($item->status != 'Approved by DPP'){
                        $nilai=true; 
                    }
                    // dd($nilai);
                    $regis[] = [
                        'id'=>$item->id,
                        'name'=>$item->name,
                        'nama_perusahaan'=>$item->NamaPerushaan,
                        'wilayah'=>$item->wilayah->name,
                        'status'=>$item->status,
                        'cekWilayah'=>$nilai
                    ];
                    $conidition = false;
                    continue;
                }
            
            if ($conidition != false) {
                $regis[] = [
                    'id'=>$item->id,
                    'name'=>$item->name,
                    'nama_perusahaan'=>$item->NamaPerushaan,
                    'wilayah'=>$item->wilayah->name,
                    'status'=>$item->status,
                    'cekWilayah'=>true
                ];
            }
            }
        }

        $response =[
            'message' => 'succes menampilkan data register',
            'data'=>$regis
       ];
       return response()->json($response,Response::HTTP_OK);
    }
 
}