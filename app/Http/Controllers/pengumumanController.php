<?php

namespace App\Http\Controllers;

use DateTime;
use Exception;
use Throwable;
use Swift_Mailer;
use Swift_Message;
use App\Models\email;
use App\Models\member;
use App\Models\Wilayah;
use Swift_SmtpTransport;
use App\Models\pengumuman;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class pengumumanController extends Controller
{
    public function index(){
        $data=pengumuman::with('wilayah')->where('status','tampil')->get();
      
        $response =[
            'message' => 'succes menampilkan data',
            'data' => $data,

       ];
       return response()->json($response,Response::HTTP_OK);
    }

    public function store(Request $request) {
        $validator=Validator::make($request->all(),[
            'wilayah' => 'required',
            'judul'=>'required',
            'keterangan'=>'required',
            'status'=>'required'
       ]);
      
       if($validator->fails()){
         return response()->json($validator->errors(), 
         Response::HTTP_UNPROCESSABLE_ENTITY);
       }
       try {
        date_default_timezone_set('Asia/Jakarta');
        $ldate = new DateTime('now');
             $data=array(
                'WilayahId' =>$request->wilayah,
                'judul'=>$request->judul,
                'keterangan'=>$request->keterangan,
                'status'=>$request->status,
                'tanggal'=>$ldate
              );
        $pengumuman=pengumuman::create($data);
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

    public function show($id)  {
        $data=pengumuman::with('wilayah')->where('id',$id)->first();
        $newtime = strtotime($data->created_at);
        $tanggal = date('M d, Y',$newtime);
        $response =[
            'message' => 'detail data',
            'data' => $data,
            'tanggal'=>$tanggal
       ];
       return response()->json($response,Response::HTTP_OK);
    }

    public function update(Request $request, $id){
        $data=pengumuman::findOrFail($id);
        $validator=Validator::make($request->all(),[
            'wilayah' => 'required',
            'judul'=>'required',
            'keterangan'=>'required',
            'status'=>'required'
       ]);
      
       if($validator->fails()){
         return response()->json($validator->errors(), 
         Response::HTTP_UNPROCESSABLE_ENTITY);
       }
           try {
            $data->Wilayah=$request->wilayah;
            $data->judul=$request->judul;
            $data->keterangan=$request->keterangan;
            $data->status=$request->status;
            $data->save();
            $response= [
                'message'=>'pengumuman update',
                'data' => $data
            ];
            return response()->json($response,Response::HTTP_OK);
           } catch (QueryException $e) {
            return response()->json([
                'message'=>"failed".$e->errorInfo
            ]);
           }
    }

    public function destroy($id){
        $data=pengumuman::findOrFail($id);
        try {
            $data->delete();
        $response=[
            'message' =>'pengumuman deleted'
        ];
        return response()->json($response,Response::HTTP_OK);
        } catch (QueryException $e) {
            return response()->json([
                'message' =>"failed".$e->errorInfo
            ]);
        }
        
    }
    
    // public static function validateTransport(){
    //         $dt = email::firstOrFail();
    //         if (!$dt) {
    //             throw new Exception('Email setting is not set');
    //         }
    //         if (!$dt->username) {
    //             throw new Exception('Username / email is not set');
    //         }
    //         if (!$dt->password) {
    //             throw new Exception('Password is not set');
    //         }
    //         //   if (!$dt->mail_driver) {
    //         //       throw new Exception('Mail driver is not set');
    //         //   }
    //         if (!$dt->host) {
    //             throw new Exception('Host is not set');
    //         }
    //         if (!$dt->port) {
    //             throw new Exception('Port is not set');
    //         }
    //         if (!$dt->encryption) {
    //             throw new Exception('Encryption is not set');
    //         }
    // }
    
    // public function sendEmail(Request $request){
    //         $this->validate($request, [
    //             'judul' => 'required',
    //             'wilayah' => 'required',
    //             'body' => 'required',
    //         ]);
             
    //         // $pengumuman=array(

    //         // );

    //         try {
    //             $data = email::firstOrFail();
    //         } catch (Throwable$th) {
    //             return response()->json('Dont have Email Account', 404);
    //         }
    
    //         self::validateTransport();
    //         $transport = (new Swift_SmtpTransport($data->host, $data->port, $data->encryption))
    //             ->setUsername($data->username)
    //             ->setPassword($data->password);
    
    //         $mailer = new Swift_Mailer($transport);
    //         $wilayah=Wilayah::where('id',$request->wilayah)->first();
    //         $tujuan=member::where('WilayahId',$request->wilayah)->get();
    //         // dd($tujauan);
    //         foreach ($tujuan as $destination) {
    //             $message = (new Swift_Message($data->receipt_subject))
    //                 ->setFrom([$data->username => $data->name])
    //                 ->setTo([$destination->email => $wilayah->name])
    //                 ->setBody($request->body, 'text/html');
    
    //             try {
    //                 $result = $mailer->send($message);
                  
    
                   
    //             } catch (\Throwable$th) {
    
    //                 return response()->json('Email sent failed', 500);
    //             }
                
    //         }
    //         return response()->json('Email sent successfully', 200);
    // }
    
}
