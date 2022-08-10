<?php

namespace App\Http\Controllers;

use App\Models\member;
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
        $data=member::where('id',$id)->with('wilayah','Cities','CompanyIndustry','provinsi')->first();
        $response =[
            'message' => 'detail data',
            'data' => $data
       ];
       return response()->json($response,Response::HTTP_OK);
    }

    public function update(Request $request,$id){
        $data=member::where('id',$id)->with('wilayah','Cities','CompanyIndustry','provinsi')->first();
        $imageName = time().'.'.$request->gambar->getClientOriginalName();
        $gambar=Storage::putFileAs('gambar',$request->gambar,$imageName);

        $data->gambar=$gambar;
        $data->name=$request->name;
        $data->email=$request->email;
        $data->NamaPerushaan=$request->NamaPerushaan;
        $data->PhoneNumber=$request->PhoneNumber;
        $data->status=$request->status;
        $data->alamat=$request->alamat;
        $data->BentukBadanUsaha=$request->BentukBadanUsaha;
        $data->KotaId=$request->KotaId;
        $data->provinsiId=$request->provinsiId;
        $data->save();
    }

    public function MemberWilayah(Request $request){

        if($request->wilayah ==='0'){
            $data=member::with('wilayah','Cities','CompanyIndustry','provinsi')->get();

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
                        'cekWilayah'=>false
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
                            'cekWilayah'=>false
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
                        'cekWilayah'=>true
                    ];
                }
                }
            }
            $response =[
                'message' => 'succes menampilkan member',
                'data' => $data
           ];
           return response()->json($response,Response::HTTP_OK);
        } else{
        // $wilayah=Wilayah::where('id',$request->wilayah)->first();
        $data=member::where('WilayahId',$request->wilayah)->with('Wilayah','Cities','CompanyIndustry','provinsi')->get();
         return response()->json([
             'data' => $data,           
         ]);   
         
        }
     }
     public function gambar(Request $request,$id){
        $member=member::find($id);
        $imageName = time().'.'.$request->gambar->getClientOriginalName();
        $gambar=Storage::putFileAs('gambar',$request->gambar,$imageName);
        // dd($nama);
        $member->gambar=$gambar;
        $member->save();
        return response()->json('berhasil upload gambar', 200);
     }
     public function getGambar($id){
        $member=member::find($id);
        $path = storage_path('app/'.$member->gambar);
        return response()->json($path, 200 );
     }
     public function index(){
        $data=member::with('wilayah','Cities','CompanyIndustry','provinsi')->get();
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