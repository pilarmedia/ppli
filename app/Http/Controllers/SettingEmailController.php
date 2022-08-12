<?php

namespace App\Http\Controllers;

use App\Models\email;
use Exception;
use Illuminate\Http\Request;
use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;

class SettingEmailController extends Controller
{
    public function getEmailAccount(){
        try {
            $data = email::firstOrFail();
                return response()->json([
                'data' => $data,
                'message' => 'Email fetched Successfully',
                ], 200);
            } catch (\Throwable$th) {
                return response()->json('Dont have Email Account', 404);
            }
    }
    
    public function postEmailAccount(Request $request){
        $this->validate($request, [
            'name' => 'required',
            'host' => 'required',
            'port' => 'required',
            'encryption' => 'required',
            'username' => 'required',
            'password' => 'required',
            ]);
            // dd($request);
            $data = email::first();
            //   return $data;
            if (!$data) {
                email::create($request->all());
            } else {
                $data->update($request->all());
            }
            // dd($data);
            return response()->json('Email Account created successfully', 200);
        }
    
        public static function validateTransport()
        {
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
                'email'=>'required'
            ]);
    
            try {
                $data = email::firstOrFail();
            } catch (\Throwable$th) {
                return response()->json('Dont have Email Account', 404);
            }
    
            self::validateTransport();
            $transport = (new Swift_SmtpTransport($data->host, $data->port, $data->encryption))
                ->setUsername($data->username)
                ->setPassword($data->password);
    
            $mailer = new Swift_Mailer($transport);
            $tes="tes";
        
                $message = (new Swift_Message($data->receipt_subject))
                    ->setFrom([$data->username => $data->name])
                    ->setTo([$request->email => 'tes'])
                    ->setBody($tes, 'text/html');
    
                try {
                    $result = $mailer->send($message);
                  
    
                    return response()->json('Email sent successfully', 200);
                } catch (\Throwable$th) {
    
                    return response()->json('Email sent failed', 500);
          
            }
        }
    
}
