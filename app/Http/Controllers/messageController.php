<?php

namespace App\Http\Controllers;
use Throwable;
use Swift_Mailer;
use SmtpTransport;
use Swift_Message;
use App\Models\User;
use App\Models\Email;
use App\Mail\toRegister;
use App\Models\Register;
use Swift_SmtpTransport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;


class messageController extends Controller
{
    public function email(Request $request,$id){
        $validator=Validator::make($request->all(),[
            'pesan' => 'required|string',            
       ]);
        $tujuan=Register::find($id)['email'];
        $pesan=$request->pesan;
        Mail::to($tujuan)->send(new toRegister($pesan));
        return response()->json([
            'status' => 'pesan terkirim',
        ]);
    }
    public static function validateTransport()
    {
        $dt = Email::firstOrFail();
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
    public function sendEmail(Request $request,$id){
        $this->validate($request, [
            'pesan' => 'required',
            'email' => 'required'
        ]);

        try {
            $data = Email::firstOrFail();
        } catch (\Throwable$th) {
            return response()->json('Dont have Email Account', 404);
        }

        self::validateTransport();
        $tujuan=User::find($id);
        $transport = (new Swift_SmtpTransport($data->host, $data->port, $data->encryption))
            ->setUsername($data->username)
            ->setPassword($data->password)
            ->setStreamOptions(array('ssl' => array('allow_self_signed' => true, 'verify_peer' => false, 'verify_peer_name' => false)));
        $mailer = new Swift_Mailer($transport);

            $message = (new Swift_Message($data->receipt_subject))
                ->setFrom([ $data->username=> $data->name])
                ->setTo([$request->email=> $tujuan->name])
                ->setBody($request->pesan, 'text/html');

            try {
                $result = $mailer->send($message);
              

                return response()->json('Email sent successfully', 200);
            } catch (Throwable$th) {

                return response()->json('Email sent failed', 500);
            }
       
    }
}
