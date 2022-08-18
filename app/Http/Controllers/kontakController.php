<?php

namespace App\Http\Controllers;

use App\Models\Kontak;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class kontakController extends Controller
{
    public function index()
    {
        $kontak=Kontak::all();
        $response =[
            'message' => 'succes dpw',
            'data' => $kontak
       ];
       return response()->json($response,Response::HTTP_OK);
    }


    public function store(Request $request){
        // return $request;
        $validator=Validator::make($request->all(),[
            'nama'=>'required',
            'alamat'=>'required',
            'email'=>'required|email',
            'nomor'=>'required|numeric|min:6',
            'status'=>'required'
       ]);
      
       if($validator->fails()){
         return response()->json($validator->errors(), 
         Response::HTTP_UNPROCESSABLE_ENTITY);
       }
       try {
             $data=array(
                'nama'=>$request->nama,
                'alamat'=>$request->alamat,
                'email'=>$request->email,
                'nomor'=>$request->nomor,
                'nama_perusahaan'=>$request->nama_perusahaan,
                'status'=>$request->status,
                'agama'=>$request->agama,
                'tanggal_lahir'=>$request->tanggal_lahir,
                'no_ktp'=>$request->no_ktp,
                'npwp'=>$request->npwp
              );
        $kontak=Kontak::create($data);
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
    public function show($id) {
        // dd($id);
        $kontak=Kontak::find($id);
        $response =[
            'message' => 'detail data',
            'data' => $kontak
       ];
       return response()->json($response,Response::HTTP_OK);
    }

    public function update(Request $request, $id) {
        // dd($request->name);
        $kontak=Kontak::findOrFail($id);
        $validator=Validator::make($request->all(),[
            'nama'=>'required',
            'email'=>'required|email',
            'nomor'=>'required|numeric|min:6',
            'status'=>'required'
           ]);
           if($validator->fails()){
             return response()->json($validator->errors(), 
             Response::HTTP_UNPROCESSABLE_ENTITY);
           }
           try {
            $kontak->update($request->all());
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

    public function destroy($id) {
        $kontak=Kontak::findOrFail($id);
        try {
            $kontak->delete();
        $response=[
            'message' =>'kontak deleted'
        ];
        return response()->json($response,Response::HTTP_OK);
        } catch (QueryException $e) {
            return response()->json([
                'message' =>"failed".$e->errorInfo
            ]);
        }
        
    }

    public function gambar(Request $request,$id){
        $kontak=Kontak::find($id);
        $imageName = time().'.'.$request->gambar->getClientOriginalName();
        $gambar=Storage::putFileAs('public/gambar',$request->gambar,$imageName);
        $tes='/storage/gambar/'. $imageName;
        // dd($nama);
        $kontak->gambar=$tes;
        $kontak->save();
        return response()->json('berhasil upload gambar', 200);
     }
     public function getGambar($id){
        $kontak=Kontak::find($id);
        $path = $kontak->gambar;
        // return $path;
        return response()->json($path, 200 );
     }
     public function gambarlogo(Request $request,$id){
        $kontak=Kontak::find($id);
        $imageName = time().'.'.$request->logo->getClientOriginalName();
        $gambar=Storage::putFileAs('public/gambar',$request->logo,$imageName);
        $tes='/storage/gambar/'. $imageName;
        // dd($nama);
        $kontak->logo=$tes;
        $kontak->save();
        return response()->json('berhasil upload gambar', 200);
     }
     public function getGambarlogo($id){
        $kontak=Kontak::find($id);
        $path = $kontak->logo;
        // return $path;
        return response()->json($path, 200 );
     }
}
