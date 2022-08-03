<?php

namespace App\Http\Controllers;

use DateTime;
use App\Models\User;
use App\Models\kontak;
use App\Models\member;
use App\Mail\MailToDPW;
use App\Mail\SendEmail;
use App\Models\Wilayah;
use App\Models\register;
use App\Models\perusahaan;
use App\Models\TemplateMail;
use Illuminate\Http\Request;
use App\Models\logRegistrasi;
use App\Models\CompanyIndustry;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
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

        // dd($cekHQ);
        // dd($cekStatus);
        foreach ($data as $item) {
            $conidition = true;
            if(($cek->roles == 'admin' ) || ($cekWilayah->HQ == '1') ){
                $regis[] = [
                    'id'=>$item->id,
                    'name'=>$item->name,
                    'nama_perusahaan'=>$item->NamaPerushaan,
                    'wilayah'=>$item->wilayah->name,
                    'status'=>$item->status,
                    'cekWilayah'=>true
                ];
            } else{
            if ($item->WilayahId == $cekRegister) {
                    $nilai=true;
                    if($item->status != 'Approved by DPP'){
                        $nilai=false; 
                    }
                    // dd($nilai);
                    $regis[] = [
                        'id'=>$item->id,
                        'name'=>$item->name,
                        'nama_perusahaan'=>$item->NamaPerushaan,
                        'wilayah'=>$item->wilayah->name,
                        'status'=>$item->status,
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
                    'cekWilayah'=>false
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

    public function register(Request $request){
        
        $cek=register::where('email',$request->email)->first();
    
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'username'=>'required|string',
            'namaPerushaan'=>'required|string',
            'nomor'=>'required|string|numeric|min:6',
            'provinsiId'=>'required',
            'KotaId'=>'required',
            'WilayahId'=>'required',
            'bentukusaha'=>'required',
            'alasan'=>'required',
        ]);

       $registrasi=register::where('username',$request->username)->first();
        if($registrasi){
            return response()->json([
                'message'=>"username sudah tersedia"
            ]); 
        }
        if (!$cek){
        date_default_timezone_set('Asia/Jakarta');
        $ldate = new DateTime('now');

        $user= register::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' =>Crypt::encryptString($request->password),
            'username' => $request->username,
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

        $email = $request->email;
        $name= $request->name;
        $datamail= TemplateMail::where('kode','mail Verified')->first();
        // dd($datamail);
        $mail=$datamail->isi_email;
        Mail::to($email)->send(new SendEmail($name,$mail));
        $data= TemplateMail::where('kode','Verified by DPP')->first();
        $mail=$data->isi_email;
        $tujuan=Wilayah::where('HQ',1)->first()['email'];
        // dd($tujuan
        Mail::to($tujuan)->send(new MailToDPW($name,$mail));
        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully',
            'user' => $user,
        ]);
    } else{
        return response()->json([
            'message'=>"anda sudah terdaptar"
        ]);
    }
    }
    public function update(Request $request,$id){
        $data=register::find($id);
        // dd($data);
        if($request->status == 'Rejected by DPP'){
            $email=$data->email;
            $name=$data->name;
            $dataMail= TemplateMail::where('kode','Rejected by DPP')->first();
            $mail=$dataMail->isi_email;
            Mail::to($email)->send(new SendEmail($name,$mail));
            $data->status=$request->status;
            $data->save();
            return response()->json([
                'status' => 'success update',
          
            ]);
        }
        if($request->status== 'Rejected by DPW'){
            $data=register::find($id);
        $data->status='Rejected by DPW';
        $email=$data->email;
        $name=$data->name;
        $dataMail= TemplateMail::where('kode','Rejected by DPW')->first();
        $mail=$dataMail->template;
        Mail::to($email)->send(new SendEmail($name,$mail));
        $data->status=$request->status;
        $data->save();
        return response()->json([
            'status' => 'success update',
      
        ]);
       
        }
        if($request->status== 'Approved by DPP'){
            $email=$data->email;
            $name=$data->name;
            $dataMailDPP= TemplateMail::where('kode','Approved by DPP')->first();
            $mail=$dataMailDPP->isi_email;
            $tujuan=Wilayah::where('id',$data->WilayahId)->first()['email'];
            Mail::to($tujuan)->send(new MailToDPW($name,$mail));
            $data->status=$request->status;
            $data->save();
            return response()->json([
                'status' => 'success update',
            ]); 
        }
        if($request->status== 'Approved by DPW'){
            if($data->status== 'Approved by DPP'){
            $email=$data->email;
            $name=$data->name;
            $dataMail= TemplateMail::where('kode','Approved by DPW')->first();
            $mail=$dataMail->isi_email;
            Mail::to($email)->send(new SendEmail($name,$mail));
            $pass=Crypt::decryptString($data->password);
            $data->status=$request->status;
            $data->save();
            $user = user::create([
                'name' => $data->name,
                'email' => $data->email,
                'password' => Hash::make($pass),
                'username' => $data->username,
                'NamaPerushaan'=>$data->NamaPerushaan,
                'PhoneNumber' =>$data->PhoneNumber,
                // 'CompanyIndustryId' => $data->CompanyIndustryId,
                'WilayahId'=>$data->WilayahId,
                'provinsiId' => $data->provinsiId,
                'KotaId' => $data->KotaId,
                'BentukBadanUsaha' => $data->BentukBadanUsaha,
                'AlasanBergabung' => $data->AlasanBergabung,
                'RegisterDate' => $data->RegisterDate,
                'status' =>'aktif',
                'roles'=>'member'
            ]);
           
            $kontak=kontak::create([
                'nama'=>$data->name,
                'email'=>$data->email,
                'nomor'=>$data->PhoneNumber,
                'status'=>'aktif'
            ]);
            // $user=User::all();
            // dd($user->id);
          
            $member = member::create([
                'name' => $data->name,
                'email' => $data->email,
                'password' => $data->password,
                'username' => $data->username,
                'NamaPerushaan'=>$data->NamaPerushaan,
                'PhoneNumber' =>$data->PhoneNumber,
                // 'CompanyIndustryId' => $data->CompanyIndustryId,
                'WilayahId'=>$data->WilayahId,
                'provinsiId' => $data->provinsiId,
                'KotaId' => $data->KotaId,
                'BentukBadanUsaha' => $data->BentukBadanUsaha,
                'AlasanBergabung' => $data->AlasanBergabung,
                'RegisterDate' => $data->RegisterDate,
                'status' =>'aktif',
               
            ]);
            $company=register::with('CompanyIndustry')->where('id',$data->id)->first();
            // dd($company->CompanyIndustry);
            $result;
            foreach($company->CompanyIndustry as $item){
                $result[]=$item->id;
            }
            $member->CompanyIndustry()->attach($result);
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
                'user' => $user,
                'authorisation' => [
                    'token' => $token,
                    'type' => 'bearer',
                ]
            ]);
    
        }else{
            return response()->json([
                'status' => 'belum di approve dpp',
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
