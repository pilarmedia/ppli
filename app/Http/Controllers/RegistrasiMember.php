<?php

namespace App\Http\Controllers;

use DateTime;
use Exception;
use Throwable;
use Swift_Mailer;
use SmtpTransport;
use Swift_Message;
use App\Models\User;
use App\Models\email;
use App\Models\iuran;
use App\Models\kontak;
use App\Models\member;
use App\Mail\MailToDPW;
use App\Mail\SendEmail;
use App\Models\Wilayah;
use App\Models\register;
use Swift_SmtpTransport;
use App\Models\perusahaan;
use App\Models\TemplateMail;
use Illuminate\Http\Request;
use App\Models\logRegistrasi;
use App\Models\CompanyIndustry;
use App\Jobs\SendEmailRegisterJob;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use App\Models\CompanyIndustry_register;
use Symfony\Component\HttpFoundation\Response;

class RegistrasiMember extends Controller
{
    public function index(){
        $data=register::with('wilayah','Cities','CompanyIndustry','provinsi')->get();
        $cek=auth()->user();
        // dd($data->wilayah);
        $cekRegister=$cek->WilayahId;
        $cekWilayah=Wilayah::where('id',$cekRegister)->first();
        // $cekStatus=register::where('email',$cek->email)->first();
        $regis=array();
        // dd($cekHQ);
        // dd($cekStatus);
        foreach ($data as $item) {
            $conidition = true;
            
            if($cek->roles == 'admin'  ){
                $regis[] = [
                    'id'=>$item->id,
                    'name'=>$item->name,
                    'nama_perusahaan'=>$item->NamaPerushaan,
                    'wilayah'=>$item->wilayah->name,
                    'status'=>$item->status,
                    'cekStatus'=>false,
                    'cekWilayah'=>false
                ];
            }elseif ($cekWilayah->HQ == '1'){
                $nilai=true;
                $nilai1=false;
                    if(($item->status == 'Approved by DPW' )  ){
                        $nilai=false; 
                    }
                    $regis[] = [
                        'id'=>$item->id,
                        'name'=>$item->name,
                        'nama_perusahaan'=>$item->NamaPerushaan,
                        'wilayah'=>$item->wilayah->name,
                        'status'=>$item->status,
                        'cekStatus'=>$nilai1,
                        'cekWilayah'=>$nilai
                    ];
                    $conidition = false;
                    continue;
                    if ($conidition != false) {
                        $regis[] = [
                            'id'=>$item->id,
                            'name'=>$item->name,
                            'nama_perusahaan'=>$item->NamaPerushaan,
                            'wilayah'=>$item->wilayah->name,
                            'status'=>$item->status,
                            'cekStatus'=>false,
                            'cekWilayah'=>true
                        ];
                    }
            }
            else{
            if ($item->WilayahId == $cekRegister) {
                    $nilai=true;
                    if($item->status == 'mail Verified' ){
                        $nilai=false; 
                    }
                 
                    // dd($nilai);
                    $regis[] = [
                        'id'=>$item->id,
                        'name'=>$item->name,
                        'nama_perusahaan'=>$item->NamaPerushaan,
                        'wilayah'=>$item->wilayah->name,
                        'status'=>$item->status,
                        'cekStatus'=>false,
                        'cekWilayah'=>$nilai
                    ];
                    $conidition = false;
                    continue;
                }
            
            if ($conidition != false) {
                $regis[] = [
                    'id'=>$item->id,
                    'name'=>$item->name,
                    'nama_perusahaan'=>$item->NamaPerushaan,
                    'wilayah'=>$item->wilayah->name,
                    'status'=>$item->status,
                    'cekStatus'=>true,
                    'cekWilayah'=>true
                ];
            }
            }
        }

        $response =[
            'message' => 'succes menampilkan data register',
            'data'=>$regis
       ];
       return response()->json($response,Response::HTTP_OK);
    }
    
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
    public function register(Request $request){
        
        $cek=register::where('email',$request->email)->first();
    
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'Username'=>'required|string',
            'namaPerushaan'=>'required|string',
            'nomor'=>'required|string|numeric|min:6',
            'provinsiId'=>'required',
            'KotaId'=>'required',
            'WilayahId'=>'required',
            'bentukusaha'=>'required',
            'alasan'=>'required',
            ]);

        $registrasi=register::where('Username',$request->Username)->first();
        //    dd('a');
            if($registrasi){
                return response()->json([
                    'message'=>"Username sudah tersedia"
                ]); 
        }
        try {
            if (!$cek){
            date_default_timezone_set('Asia/Jakarta');
            $ldate = new DateTime('now');
       
           
            $user= register::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' =>Crypt::encryptString($request->password),
                'Username' => $request->Username,
                'NamaPerushaan'=>$request->namaPerushaan,
                'PhoneNumber' =>$request->nomor,
                'WilayahId' => $request->WilayahId,
                'provinsiId' => $request->provinsiId,
                'KotaId' => $request->KotaId,
                'BentukBadanUsaha' => $request->bentukusaha,
                'AlasanBergabung' => $request->alasan,
                'RegisterDate' => $ldate,
                'status' =>'mail Verified',
                'roles'=>'member'
            ]);
    
            $user->CompanyIndustry()->attach($request->companyindustry);
            $logRegitrasi=logRegistrasi::create([
                'nama'=>$request->name,
                'email'=>$request->email,
                'NamaPerushaan'=>$request->namaPerushaan,
                'PhoneNumber'=>$request->nomor,
                'RegisterDate'=>$ldate

            ]);
            // dd('a');

            // email
                // $data = email::firstOrFail();
                // self::validateTransport();
                // $email = $request->email;
                // // dd('a');
                // $name= $request->name;
                // // dd('b');
                // $datamail= TemplateMail::where('kode','mail Verified')->first();
                // // dd($datamail);
                // $mail=$datamail->isi_email;
                // $details['email'] =$email;
                // $details['name'] =$name;
                // $details['mail'] =$mail;
                // dispatch(new SendEmailRegisterJob($details));
                //     $transport = (new Swift_SmtpTransport($data->host, $data->port, $data->encryption))
                //     ->setUsername($data->username)
                //     ->setPassword($data->password);
                //     $mailer = new Swift_Mailer($transport);
                //     $message = (new Swift_Message($data->receipt_subject))
                //         ->setFrom([ $data->username=> $data->name])
                //         ->setTo([$email=> $request->name])
                //         ->setBody('saudara '.$name.' '.$mail, 'text/html');
                // $data1= TemplateMail::where('kode','Verified by DPW')->first();
                // // dd($data1);
                // $mail=$data1->isi_email;
                // $tujuan=Wilayah::where('HQ',true)->first();
                // // dd($tujuan->email);
                // $details['tujuan_email'] =$tujuan->email;
                // $details['tujuan_name'] =$tujuan->name;
                // $details['tujuan_mail'] =$mail;
                // dispatch(new SendEmailRegisterJob($details));
                //     $message2 = (new Swift_Message($data->receipt_subject))
                //         ->setFrom([ $data->username=> $data->name])
                //         ->setTo([$tujuan->email=> $tujuan->name])
                //         ->setBody($mail.' saudara '.$name, 'text/html');

                //     $result = $mailer->send($message);
                //     $result1 = $mailer->send($message2);
            
            //end email
            return response()->json([
                'message' => 'User created successfully',
            ]);
            } else{
                return response()->json([
                    'message'=>"anda sudah terdaptar"
                ]);
            }
        } catch (\Throwable $th) {
            //throw $th;
        } 
       
    }
    public function update(Request $request,$id){
        $data1=register::find($id);
        // dd($data1);
        $email=$data1->email;
       
        $name=$data1->name;
        if($request->status == 'Rejected by DPP'){
            $data = email::firstOrFail();
            self::validateTransport();
            $dataMail= TemplateMail::where('kode','Rejected by DPP')->first();
            $mail=$dataMail->isi_email;
            $transport = (new Swift_SmtpTransport($data->host, $data->port, $data->encryption))
            ->setUsername($data->username)
            ->setPassword($data->password);
            $mailer = new Swift_Mailer($transport);

            $message = (new Swift_Message($data->receipt_subject))
                ->setFrom([ $data->username=> $data->name])
                ->setTo([$email=> $name])
                ->setBody('saudara '.$name.' '.$mail, 'text/html');
            $result = $mailer->send($message);
            // Mail::to($email)->send(new SendEmail($name,$mail));
            $data1->status=$request->status;
            $data1->save();
            return response()->json([
                'status' => 'success update',
          
            ]);
        }
        if($request->status== 'Rejected by DPW'){
            $data = email::firstOrFail();
            self::validateTransport();
         // $data->status='Rejected by DPW';
            $dataMail= TemplateMail::where('kode','Rejected by DPW')->first();
            $mail=$dataMail->isi_email;

            $transport = (new Swift_SmtpTransport($data->host, $data->port, $data->encryption))
            ->setUsername($data->username)
            ->setPassword($data->password);
            $mailer = new Swift_Mailer($transport);

            $message = (new Swift_Message($data->receipt_subject))
                ->setFrom([ $data->username=> $data->name])
                ->setTo([$email=> $name])
                ->setBody('saudara '.$name.' '.$mail, 'text/html');
            $result = $mailer->send($message);

            // Mail::to($email)->send(new SendEmail($name,$mail));
            $data1->status=$request->status;
            $data1->save();
            return response()->json([
                'status' => 'success update',
        
            ]);  
        }
        if($request->status== 'Approved by DPW'){
            //email 
                // $data = email::firstOrFail();
                // self::validateTransport();
                // $dataMailDPP= TemplateMail::where('kode','Approved by DPW')->first();
                // $mail=$dataMailDPP->isi_email;
                // $tujuan=Wilayah::where('id',$data1->WilayahId)->first();
                // $transport = (new Swift_SmtpTransport($data->host, $data->port, $data->encryption))
                // ->setUsername($data->username)
                // ->setPassword($data->password);
                // $mailer = new Swift_Mailer($transport);
        
                // $message = (new Swift_Message($data->receipt_subject))
                //     ->setFrom([ $data->username=> $data->name])
                //     ->setTo([$tujuan->email=> $tujuan->name])
                //     ->setBody($mail.' saudara '.$name, 'text/html');
                // $result = $mailer->send($message);
            //end email
            // Mail::to($tujuan)->send(new MailToDPW($name,$mail));
            $data1->status=$request->status;
            $data1->save();
            return response()->json([
                'status' => 'success update',
            ]); 
        }
        if($request->status== 'Approved by DPP'){
            if($data1->status== 'Approved by DPW'){
            //email    
                // $data = email::firstOrFail();
                // self::validateTransport();
          
                // $dataMail= TemplateMail::where('kode','Approved by DPP')->first();
                // $mail=$dataMail->isi_email;

                // $transport = (new Swift_SmtpTransport($data->host, $data->port, $data->encryption))
                // ->setUsername($data->username)
                // ->setPassword($data->password);
                // $mailer = new Swift_Mailer($transport);
        
                // $message = (new Swift_Message($data->receipt_subject))
                //     ->setFrom([ $data->username=> $data->name])
                //     ->setTo([$email=> $name])
                //     ->setBody('saudara '.$name.' '.$mail, 'text/html');
                // $result = $mailer->send($message);
            //end email    
                // // Mail::to($email)->send(new SendEmail($name,$mail));
                $pass=Crypt::decryptString($data1->password);
                $data1->status=$request->status;
                $data1->save();
                $user = user::create([
                    'name' => $data1->name,
                    'email' => $data1->email,
                    'password' => Hash::make($pass),
                    'Username' => $data1->Username,
                    'NamaPerushaan'=>$data1->NamaPerushaan,
                    'PhoneNumber' =>$data1->PhoneNumber,
                    // 'CompanyIndustryId' => $data->CompanyIndustryId,
                    'WilayahId'=>$data1->WilayahId,
                    'provinsiId' => $data1->provinsiId,
                    'KotaId' => $data1->KotaId,
                    'BentukBadanUsaha' => $data1->BentukBadanUsaha,
                    'AlasanBergabung' => $data1->AlasanBergabung,
                    'RegisterDate' => $data1->RegisterDate,
                    'status' =>'aktif',
                    'roles'=>'member'
                ]);
            
            
                $kontak=kontak::create([
                    'nama'=>$data1->name,
                    'email'=>$data1->email,
                    'nomor'=>$data1->PhoneNumber,
                    'nama_perusahaan'=>$data1->NamaPerushaan,
                    'status'=>'aktif'
                ]);
                // $user=User::all();
                // dd($user->id);
            
                $member = member::create([
                    'name' => $data1->name,
                    'email' => $data1->email,
                    'password' => $data1->password,
                    'username' => $data1->Username,
                    'NamaPerushaan'=>$data1->NamaPerushaan,
                    'PhoneNumber' =>$data1->PhoneNumber,
                    // 'CompanyIndustryId' => $data->CompanyIndustryId,
                    'WilayahId'=>$data1->WilayahId,
                    'provinsiId' => $data1->provinsiId,
                    'KotaId' => $data1->KotaId,
                    'BentukBadanUsaha' => $data1->BentukBadanUsaha,
                    'AlasanBergabung' => $data1->AlasanBergabung,
                    'RegisterDate' => $data1->RegisterDate,
                    'status' =>'aktif',
                
                ]);
                $company=CompanyIndustry_register::where('register_id',$data1->id)->get();
                // dd($company->CompanyIndustry_id);

                $result1=array();
                foreach($company as $item){
                    $result1[]=$item->CompanyIndustry_id;
                }
                // dd($result1);
                $member->CompanyIndustry()->attach($result1);
                $bulan=array('januari','februari','maret','april','mei','juni','juli','agustus','september','oktober','november','desember');
                $ldate = date('Y');
                for($i=1;$i<13;$i++){
                    $result = array(
                        'bulan' => $bulan[$i-1],
                        'memberId' => $member->id,
                        'tahun'=>$ldate,
                        'status'=>'belum lunas'
                    ); 
                    $iuran=iuran::create($result);             
                }

            
                // dd($company->CompanyIndustry);
            
                $perusahaan=perusahaan::create([
                    'memberId'=>$member->id
                ]);
                $has_permission = DB::table('role_has_permissions')->leftJoin('permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')->where('role_id', $id)->get(); 
                $count=count($has_permission);
                $data_permission=[];
                for ($i=0;$i<$count;$i++){
                array_push($data_permission,$has_permission[$i]->name);
                }
                
                $user->syncPermissions($data_permission);
        
                
            
                $token = Auth::login($user);
                return response()->json([
                    'status' => 'success update',
                    'message' => 'User created successfully',
                    'authorisation' => [
                        'token' => $token,
                        'type' => 'bearer',
                    ]
                ]);
    
            }else{
             return response()->json([
                'status' => 'belum di approve DPW',
            ]);  
        }

        }

    }
    public function deleteRegister($id){
        $register=register::findOrFail($id);
        try {
            $register->delete();
        $response=[
            'message' =>'data deleted'
        ];
        return response()->json($response,Response::HTTP_OK);
        } catch (QueryException $e) {
            return response()->json([
                'message' =>"failed".$e->errorInfo
            ]);
        }
    }
    public function showRegister($id){
        $data=register::with('wilayah','Cities','CompanyIndustry','provinsi')->where('id',$id)->get();
       return response()->json($data, 200);
    }
    public function MemberStatus(Request $request){
        // dd($request->nama);
        $data=member::where('status',$request->status)->with('wilayah','Cities','CompanyIndustry','provinsi')->get();
        // dd($data);
        return response()->json([
            'data' => $data,           
        ]);  
          
    }
    public function MemberWilayah(Request $request){
       $wilayah=Wilayah::where('name',$request->name)->first();
       $data=member::where('WilayahId',$wilayah->id)->with('wilayah','Cities','CompanyIndustry','provinsi')->get();
    // $data=member::with('Wilayah')->get();
        return response()->json([
            'data' => $data,           
        ]);       
    }

    
    

    // public function rejectedDPP($id){
    //     // dd($id);
    //     $data=register::find($id);
    //     $data->status='Rejected by DPP';
    //     $email=$data->email;
    //     $name=$data->name;
    //     $data->save();
    //     // $data=register::where('id',$id)->first();
      
        
    //     $dataMail= TemplateMail::where('kode','Rejected by DPP')->first();
    //     $mail=$dataMail->isi_email;
    //     Mail::to($email)->send(new SendEmail($name,$mail));
    //     return response()->json([
    //         'status' => 'success update',
      
    //     ]);
    // }
    // public function rejectedDPW($id){
    //     // dd($id);
    //     $data=register::find($id);
    //     $data->status='Rejected by DPW';
    //     $email=$data->email;
    //     $name=$data->name;
    //     $data->save();
    //     // dd($email);
    //     // $data=register::where('id',$id)->first();
    //     $dataMail= TemplateMail::where('kode','Rejected by DPW')->first();
    //     $mail=$dataMail->template;
    //     Mail::to($email)->send(new SendEmail($name,$mail));
    //     return response()->json([
    //         'status' => 'success update',
      
    //     ]);
       
       
    // }
   
    // public function ApprovedDPP($id){
    //     // dd($id);
        
    //     $data=register::find($id);
    //     $data->status='Approved by DPP';
    //     $email=$data->email;
    //     $name=$data->name;
    //     $data->save();
    //     // $data=register::where('id',$id)->first();
      
    //     // $dataMail= TemplateMail::where('name','Approved by DPP')->first();
    //     // $mail=$dataMail->template;
    //     // Mail::to($email)->send(new SendEmail($name,$mail));
    //     $dataMailDPP= TemplateMail::where('kode','Approved by DPP')->first();
    //     $mail=$dataMailDPP->isi_email;
    //     $tujuan=Wilayah::where('name',$dataMailDPP->tujuan)->first()['email'];
    //     // $emailDPP=$dataMailDPP->tujuan;
    //     Mail::to($tujuan)->send(new MailToDPW($name,$mail));
    //     return response()->json([
    //         'status' => 'success update',
      
            
    //     ]); 
    // }
    // public function ApprovedDPW($id){
    //     // dd('cek');
    //     $data=register::find($id);
    //     // if( $data->status_DPP == 'disetujui'){
    //         // dd($data);
    //     $data->status='Approved by DPW';
    //     $email=$data->email;
    //     $name=$data->name;
    //     $data->save();
    //     $dataMail= TemplateMail::where('kode','Approved by DPW')->first();
    //     $mail=$dataMail->isi_email;
    //     Mail::to($email)->send(new SendEmail($name,$mail));
    //     $pass=Crypt::decryptString($data->password);
    //     $user = user::create([
    //         'name' => $data->name,
    //         'email' => $data->email,
    //         'password' => Hash::make($pass),
    //         'username' => $data->username,
    //         'NamaPerushaan'=>$data->NamaPerushaan,
    //         'PhoneNumber' =>$data->PhoneNumber,
    //         'CompanyIndustryId' => $data->CompanyIndustryId,
    //         'WilayahId'=>$data->WilayahId,
    //         'provinsiId' => $data->provinsiId,
    //         'KotaId' => $data->KotaId,
    //         'BentukBadanUsaha' => $data->BentukBadanUsaha,
    //         'AlasanBergabung' => $data->AlasanBergabung,
    //         'RegisterDate' => $data->RegisterDate,
    //         'status' =>'aktif',
    //         'roles'=>'member'

    //     ]);
    //     // $pass=Crypt::decryptString($data->password);
    //     $member = member::create([
    //         'name' => $data->name,
    //         'email' => $data->email,
    //         'password' => $pass,
    //         'username' => $data->username,
    //         'NamaPerushaan'=>$data->NamaPerushaan,
    //         'PhoneNumber' =>$data->PhoneNumber,
    //         'CompanyIndustryId' => $data->CompanyIndustryId,
    //         'WilayahId'=>$data->WilayahId,
    //         'provinsiId' => $data->provinsiId,
    //         'KotaId' => $data->KotaId,
    //         'BentukBadanUsaha' => $data->BentukBadanUsaha,
    //         'AlasanBergabung' => $data->AlasanBergabung,
    //         'RegisterDate' => $data->RegisterDate,
    //         'status' =>'aktif',
           

    //     ]);
    //     $kontak=kontak::create([
    //         'nama'=>$data->name,
    //         'email'=>$data->email,
    //         'nomor'=>$data->PhoneNumber,
    //         'status'=>'aktif'
    //     ]);
    //     // $user1=User::all();
    //     $perusahaan=perusahaan::create([
    //         'memberId'=>$user->id
    //     ]);

    //     $has_permission = DB::table('role_has_permissions')->leftJoin('permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')->where('role_id', $id)->get(); 
    //     $count=count($has_permission);
    //     $data_permission=[];
    //     for ($i=0;$i<$count;$i++){
    //        array_push($data_permission,$has_permission[$i]->name);
    //     }
        
    //     $user->syncPermissions($data_permission);


    //     $token = Auth::login($user);
    //     return response()->json([
    //         'status' => 'success',
    //         'message' => 'User created successfully',
    //         'user' => $user,
    //         'authorisation' => [
    //             'token' => $token,
    //             'type' => 'bearer',
    //         ]
    //     ]);
    //     // }else{
    //     //     return response()->json([
    //     //         'status' => 'belum disetujui DPP',
    //     //     ]); 
    //     // } 
    // }

    // public function showToDPW(){
    //     $data=register::where('status','Approved by DPP')->with('wilayah','Cities','CompanyIndustry','provinsi')->get();
    //     $response =[
    //         'message' => 'succes menampilkan data register',
    //         'data' => $data
    //    ];
    //    return response()->json($response,Response::HTTP_OK);
    // }

    // public function showToDPP(){
    //     $data=register::where('status','mail Verified')->with('wilayah','Cities','CompanyIndustry','provinsi')->get();
    //     $response =[
    //         'message' => 'succes menampilkan data register',
    //         'data' => $data
    //    ];
    //    return response()->json($response,Response::HTTP_OK);
    // }
  

   
   

}
