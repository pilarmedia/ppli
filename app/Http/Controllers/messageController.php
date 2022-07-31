<?php

namespace App\Http\Controllers;
use App\Mail\toRegister;
use App\Models\register;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class messageController extends Controller
{
    public function email(Request $request,$id){
        $validator=Validator::make($request->all(),[
            'pesan' => 'required|string',            
       ]);
        $tujuan=register::find($id)['email'];
        $pesan=$request->pesan;
        Mail::to($tujuan)->send(new toRegister($pesan));
        return response()->json([
            'status' => 'pesan terkirim',
        ]);
    }
}
