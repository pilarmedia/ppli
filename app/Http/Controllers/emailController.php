<?php

namespace App\Http\Controllers;

use App\Models\TemplateMail;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class emailController extends Controller
{
    public function index()
    {
        $mail=TemplateMail::all();
        $response =[
            'message' => 'succes menampilkan template email',
            'data' => $mail
       ];
       return response()->json($response,Response::HTTP_OK);
    }


    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'kode'=>'required',
            // 'tujuan'=>'required',
            'judul_email'=>'required',
            'isi_email'=>'required'
       ]);
      
       if($validator->fails()){
         return response()->json($validator->errors(), 
         Response::HTTP_UNPROCESSABLE_ENTITY);
       }
       try {
             $data=array(
                'kode' => $request->kode,
                'tujuan' => $request->tujuan,
                'judul_email'=> $request->judul_email,
                'isi_email' => $request->isi_email
              );
        $mail=TemplateMail::create($data);
        $response= [
            'message'=>'add succes ',
            'data' => $mail
        ];
        return response()->json($response,Response::HTTP_CREATED);
       
       } catch (QueryException $e) {
        return response()->json([
            'message'=>"failed".$e->errorInfo
        ]);
       }    
    return response()->json([
        'status' => 'success',
    ]);
 
    }

    public function show($id)
    {
        // dd($id);
        $mail=TemplateMail::find($id);
        $response =[
            'message' => 'detail data',
            'data' => $mail
       ];
       return response()->json($response,Response::HTTP_OK);
    }


    public function update(Request $request, $id)
    {
        // dd($request->name);
        $mail=TemplateMail::findOrFail($id);
        $validator=Validator::make($request->all(),[
            'tipe_tujuan'=>'required',
            'kodeTujuan'=>'required',
            'judul_email'=>'required',
            'isi_email'=>'required'
           ]);
           if($validator->fails()){
             return response()->json($validator->errors(), 
             Response::HTTP_UNPROCESSABLE_ENTITY);
           }
           try {
            $mail->update($request->all());
            $response= [
                'message'=>'transaction update',
                'data' => $mail
            ];
            return response()->json($response,Response::HTTP_OK);
           } catch (QueryException $e) {
            return response()->json([
                'message'=>"failed".$e->errorInfo
            ]);
           }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $mail=TemplateMail::findOrFail($id);
        try {
            $mail->delete();
        $response=[
            'message' =>'mail deleted'
        ];
        return response()->json($response,Response::HTTP_OK);
        } catch (QueryException $e) {
            return response()->json([
                'message' =>"failed".$e->errorInfo
            ]);
        }
        
    }
}
