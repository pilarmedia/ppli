<?php

namespace App\Http\Controllers;

use App\Models\iuran;
use App\Models\member;
use App\Models\iuranAnggota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class iuranController extends Controller
{
    public function index (){
        // dd('a');
        $data=iuran::with('member')->get();
        return response()->json($data, 200);
    }
    public function updateShow(Request $request,$id){
        $data=iuran::where('tahun',$request->tahun)->where('memberId',$id)->get();
        return response()->json($data, 200);

    }

    public function update(Request $request,$id){
        $iuran=iuran::find($id)->first();
        $member=member::find($iuran->memberId);
        $iuranAnggota=iuranAnggota::where('WilayahId',$member->WilayahId)->get();
        $validator=Validator::make($request->all(),[
            'tanggal_bayar'=>'required',
            'status'=>'required'
         ]);
           if($validator->fails()){
             return response()->json($validator->errors(), 
             Response::HTTP_UNPROCESSABLE_ENTITY);
           }
           $iuran->tanggal_bayar=$request->tanggal_bayar;
           $iuran->status=$request->status;
           $iuran->jumlah=$iuranAnggota->jumlah;
           $iuran->save();
           return response()->json('update berhasil', 200);
        //    $iuran->jumlah=
    }
}
