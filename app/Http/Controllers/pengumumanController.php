<?php

namespace App\Http\Controllers;

use Exception;
use Throwable;
use Swift_Mailer;
use Swift_Message;
use App\Models\email;
use App\Models\member;
use App\Models\Wilayah;
use Swift_SmtpTransport;
use Illuminate\Http\Request;

class pengumumanController extends Controller
{
    
    public static function validateTransport(){
            $dt = email::firstOrFail();
            if (!$dt) {
                throw new Exception('Email setting is not set');
            }
            if (!$dt->username) {
                throw new Exception('Username / email is not set');
            }
            if (!$dt->password) {
                throw new Exception('Password is not set');
            }
            //   if (!$dt->mail_driver) {
            //       throw new Exception('Mail driver is not set');
            //   }
            if (!$dt->host) {
                throw new Exception('Host is not set');
            }
            if (!$dt->port) {
                throw new Exception('Port is not set');
            }
            if (!$dt->encryption) {
                throw new Exception('Encryption is not set');
            }
    }
    
        public function sendEmail(Request $request)
        {
            $this->validate($request, [
                'judul' => 'required',
                'wilayah' => 'required',
                'body' => 'required',
            ]);
             
            // $pengumuman=array(

            // );

            try {
                $data = email::firstOrFail();
            } catch (Throwable$th) {
                return response()->json('Dont have Email Account', 404);
            }
    
            self::validateTransport();
            $transport = (new Swift_SmtpTransport($data->host, $data->port, $data->encryption))
                ->setUsername($data->username)
                ->setPassword($data->password);
    
            $mailer = new Swift_Mailer($transport);
            $wilayah=Wilayah::where('id',$request->wilayah)->first();
            $tujuan=member::where('WilayahId',$request->wilayah)->get();
            // dd($tujauan);
            foreach ($tujuan as $destination) {
                $message = (new Swift_Message($data->receipt_subject))
                    ->setFrom([$data->username => $data->name])
                    ->setTo([$destination->email => $wilayah->name])
                    ->setBody($request->body, 'text/html');
    
                try {
                    $result = $mailer->send($message);
                  
    
                   
                } catch (\Throwable$th) {
    
                    return response()->json('Email sent failed', 500);
                }
                
            }
            return response()->json('Email sent successfully', 200);
        }
    
}
