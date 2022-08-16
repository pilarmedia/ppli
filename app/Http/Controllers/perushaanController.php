<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Perusahaan;
use App\Models\kategori_perusahaan;
use Illuminate\Http\Request;

use Symfony\Component\HttpFoundation\Response;


class perushaanController extends Controller
{
    public function index(){
       $data=Perusahaan::with('kategori')->get();
        $response =[
            'message' => 'show perusahaan',
            'data' => $data
       ];
       return response()->json($response,Response::HTTP_OK);
    }
    public function filter($id){
        
        $data=Kategori::with('perusahaan')->where('id',$id)->get();
        $response =[
            'message' => 'show perusahaan',
            'data' => $data
       ];
       return response()->json($response,Response::HTTP_OK);
    }

    public function updatedetail(Request $request, $id){
       
        $data=Perusahaan::with('kategori','member')->where('memberId',$id)->first();
        $id=$data->id;
        // $data->path=$request->file('image')->store('public/images');
        // $data->title=$request->file('image')->getClientOriginalName();
       if($request->image != null){
        $imageName = time().'.'.$request->image->extension();  
       
        $request->image->move(public_path('images'), $imageName);
        $image_path = "/images/" . $imageName;
        $data->title=$imageName;
        $data->path=$image_path;
       }
        
        
        $data->profile=$request->profile;
        $data->tahun_berdiri=$request->tahun_berdiri;
        $data->save();

       if($request->kategori != null){
        $data->kategori()->detach();
       }
        $data->kategori()->attach($request->kategori);

        $response =[
            'message' => 'update berhasil',
            'data' => $data
       ];
       return response()->json($response,Response::HTTP_OK);
   
    }
}