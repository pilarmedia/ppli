<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Register;
use App\Mail\SendPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class ForgotPasswordController extends Controller
{
    public function forgot(Request $request){
               
        $data=Register::where('email',$request->email)->first();
     
        // $cek=Crypt::decryptString($data->password);
        if(!$data){
            return response()->json([
                'message'=>"anda belum terdaftar"
            ]);
        }else{
            $cek=Crypt::decryptString($data->password);
            Mail::to($request->email)->send(new SendPassword($cek));
            return response()->json([
                'message'=>"silahkan cek email"
            ]);
        }
    }
    public function reset(Request $request){

    }
}
