<?php

namespace App\Http\Controllers;

use DateTime;
use Exception;
use Throwable;
use Swift_Mailer;
use SmtpTransport;
use Swift_Message;
use App\Models\User;
use App\Models\Email;
use App\Models\Iuran;
use App\Models\Kontak;
use App\Models\Member;
use App\Mail\MailToDPW;
use App\Mail\SendEmail;
use App\Models\Wilayah;
use App\Models\Register;
use Swift_SmtpTransport;
use App\Models\Perusahaan;
use App\Models\TemplateMail;
use Illuminate\Http\Request;
use App\Models\LogRegistrasi;
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
        $data=Register::with('wilayah','Cities','CompanyIndustry','provinsi')->get();
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
    public function register(Request $request){
        
        $cek=Register::where('email',$request->email)->first();
    
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

        $registrasi=Register::where('Username',$request->Username)->first();
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
            $cekWilayah=wilayah::where('HQ',true)->first();
            $status='mail Verified';
            if($cekWilayah->id == $request->WilayahId){
                $status='Approved by DPW';
            }
            $user= Register::create([
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
                'status' =>$status,
                'roles'=>'member'
            ]);
    
            $user->CompanyIndustry()->attach($request->companyindustry);
            $logRegitrasi=LogRegistrasi::create([
                'nama'=>$request->name,
                'email'=>$request->email,
                'NamaPerushaan'=>$request->namaPerushaan,
                'PhoneNumber'=>$request->nomor,
                'RegisterDate'=>$ldate

            ]);
 
            // email
                $data = Email::firstOrFail();
                self::validateTransport();
                $email = $request->email;
              
                $name= $request->name;
                $datamail= TemplateMail::where('kode','mail Verified')->first();
                //queue
                    $mail=$datamail->isi_email;
                    // $details['email'] =$email;
                    // $details['name'] =$name;
                    // $details['mail'] =$mail;
                    // dispatch(new SendEmailRegisterJob($details));
                //endqueue
                    $transport = (new Swift_SmtpTransport($data->host, $data->port, $data->encryption))
                    ->setUsername($data->username)
                    ->setPassword($data->password);
                    $mailer = new Swift_Mailer($transport);
                    $message = (new Swift_Message($data->receipt_subject))
                        ->setFrom([ $data->username=> $data->name])
                        ->setTo([$email=> $request->name])
                        ->setBody('saudara '.$name.' '.$mail, 'text/html');
                $data1= TemplateMail::where('kode','Verified by DPW')->first();
                $mail=$data1->isi_email;
                $tujuan=Wilayah::where('HQ',true)->first();
                // queue
                    // dd($tujuan->email);
                    // $details['tujuan_email'] =$tujuan->email;
                    // $details['tujuan_name'] =$tujuan->name;
                    // $details['tujuan_mail'] =$mail;
                    // dispatch(new SendEmailRegisterJob($details));
                //end queue
                    $message2 = (new Swift_Message($data->receipt_subject))
                        ->setFrom([ $data->username=> $data->name])
                        ->setTo([$tujuan->email=> $tujuan->name])
                        ->setBody($mail.' saudara '.$name, 'text/html');

                    $result = $mailer->send($message);
                    $result1 = $mailer->send($message2);
            
            // end email
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
        $data1=Register::find($id);
        // dd($data1);
        $email=$data1->email;
       $cekWilayah=wilayah::where('HQ',true)->first();
        $name=$data1->name;
        if($request->status == 'Rejected by DPP'){
            $data = Email::firstOrFail();
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
            $data = Email::firstOrFail();
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
        if($request->status == 'Approved by DPW'){
            // email 
                $data = Email::firstOrFail();
                self::validateTransport();
                $dataMailDPP= TemplateMail::where('kode','Approved by DPW')->first();
                $mail=$dataMailDPP->isi_email;
                $tujuan=Wilayah::where('id',$data1->WilayahId)->first();
                $transport = (new Swift_SmtpTransport($data->host, $data->port, $data->encryption))
                ->setUsername($data->username)
                ->setPassword($data->password);
                $mailer = new Swift_Mailer($transport);
        
                $message = (new Swift_Message($data->receipt_subject))
                    ->setFrom([ $data->username=> $data->name])
                    ->setTo([$tujuan->email=> $tujuan->name])
                    ->setBody($mail.' saudara '.$name, 'text/html');
                $result = $mailer->send($message);
            // end email
            // Mail::to($tujuan)->send(new MailToDPW($name,$mail));
            $data1->status=$request->status;
            $data1->save();
            return response()->json([
                'status' => 'success update',
            ]); 
        }

        if($request->status== 'Approved by DPP' ){
            if($data1->status== 'Approved by DPW'){
            // email    
                $data = Email::firstOrFail();
                self::validateTransport();
          
                $dataMail= TemplateMail::where('kode','Approved by DPP')->first();
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
            // end email    
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
            
            
                $kontak=Kontak::create([
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
                dd($result1);
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
                    $iuran=Iuran::create($result);             
                }

            
                // dd($company->CompanyIndustry);
            
                $perusahaan=Perusahaan::create([
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
        $register=Register::findOrFail($id);
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
        $data=Register::with('wilayah','Cities','CompanyIndustry','provinsi')->where('id',$id)->get();
       return response()->json($data, 200);
    }
    public function MemberStatus(Request $request){
        // dd($request->nama);
        $data=Member::where('status',$request->status)->with('wilayah','Cities','CompanyIndustry','provinsi')->get();
        // dd($data);
        return response()->json([
            'data' => $data,           
        ]);  
          
    }
    public function MemberWilayah(Request $request){
       $wilayah=Wilayah::where('name',$request->name)->first();
       $data=Member::where('WilayahId',$wilayah->id)->with('wilayah','Cities','CompanyIndustry','provinsi')->get();
    // $data=member::with('Wilayah')->get();
        return response()->json([
            'data' => $data,           
        ]);       
    }

    
}
