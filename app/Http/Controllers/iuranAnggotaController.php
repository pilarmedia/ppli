<?php

namespace App\Http\Controllers;

use App\Models\iuranAnggota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class iuranAnggotaController extends Controller
{
   public function index(Request $request){
        $data=iuranAnggota::with('Wilayah')->where('tahun',$request->tahun)->where('WilayahId',$request->WilayahId)->get();
       return response()->json($data, 200);
   }
   public function show($id){
      $data=iuranAnggota::with('Wilayah')->first();
      return response()->json($data, 200);
   }
   public function update(Request $request,$id){
      $data=iuranAnggota::find($id);
      $validator=Validator::make($request->all(),[
         'iuran'=>'required',
         'setoran_DPP'=>'required'
      ]);
        if($validator->fails()){
          return response()->json($validator->errors(), 
          Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $data->iuran=$request->iuran;
        $data->setoran_DPP=$request->setoran_DPP;
        $data->save();
        return response()->json('update berhasil', 200);
   }
}
