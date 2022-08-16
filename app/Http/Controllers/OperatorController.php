<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Member;
use App\Models\Register;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class OperatorController extends Controller
{
    
    public function UpdateStatus($id){
        $user=Member::where('id',$id)->first();
        if($user->status=='aktif'){
            $user->status='tidak aktif';
        }else{
            $user->status='aktif';
        }
        $user->save();
        $member=User::where('email',$user->email)->first();
        if($member->status=='aktif'){
            $member->status='tidak aktif';
        }else{
            $member->status='aktif';
        }
        $member->save();

        return response()->json([
            'status' => 'success update',
      
        ]);
    }
    public function member(Request $request){
        $data=Member::with('wilayah','Cities','CompanyIndustry','provinsi')->get();
        return response()->json([
            'data' =>$data,
      
        ]);
    }
    public function showUser($id){
        $data=User::findOrFail($id);
        return response()->json([
            'data' =>$data,
      
        ]);
    }
    public function updateUser(Request $request, $id){
        $cek=Member::where('username',$request->username)->first();
        $cekemail=Member::where('email',$request->email)->first();
        $data=Member::findOrFail($id);
        $user=user::where('username',$data->username)->first();
        
        // if(!$cek){ 
        //     if(!$cekemail){
        $validator=Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|',
            'username'=>'required|string',
            'namaPerushaan'=>'required|string',
            'nomor'=>'required|string',
            'companyindustry'=>'required',
            'KotaId'=>'required',
            'WilayahId'=>'required',
            'bentukusaha'=>'required',
            'alasan'=>'required',
           ]);
           if($validator->fails()){
             return response()->json($validator->errors(), 
             Response::HTTP_UNPROCESSABLE_ENTITY);
           }
          
           try {     
                if($data->username!=$request->username){
                    if(!$cek){
                    $member->username=$request->username;
                    }else{
                        return response()->json([
                            'message'=>"username tersedia"
                    ]);
                    }
                } 
                if($data->email!=$request->email){
                    if(!$cek){
                    $user->email=$request->email;
                    }else{
                        return response()->json([
                            'message'=>"email tersedia"
                    ]);
                    }
                }           
                $user->name=$request->name;
                $user->email=$request->email;
                $user->username=$request->username;
                $user->NamaPerushaan=$request->namaPerushaan;
                $user->PhoneNumber=$request->nomor;
                $user->CompanyIndustryId=$request->companyindustry;
                $user->WilayahId=$request->WilayahId;
                $user->KotaId=$request->KotaId;
                $user->AlasanBergabung=$request->alasan;
                $user->BentukBadanUsaha=$request->bentukusaha;
                $user->save();
                $data->name=$request->name;
                $data->email=$request->email;
                $data->username=$request->username;
                $data->NamaPerushaan=$request->namaPerushaan;
                $data->PhoneNumber=$request->nomor;
                $data->CompanyIndustryId=$request->companyindustry;
                $data->WilayahId=$request->WilayahId;
                $data->KotaId=$request->KotaId;
                $data->AlasanBergabung=$request->alasan;
                $data->BentukBadanUsaha=$request->bentukusaha;
                $data->save();
                    $response= [
                        'message'=>'data update',
                        'data' => $data
                    ];
                    return response()->json($response,Response::HTTP_OK);
           } catch (QueryException $e) {
                return response()->json([
                    'message'=>"failed".$e->errorInfo
            ]);
            
            
           }
      
    }
    public function deleteUser($id){
        $member=Member::find($id);
        $user=User::where('email',$member->email)->first();
        try {
            $member->delete();
            $user->delete();

        $response=[
            'message' =>'member deleted'
        ];
        return response()->json($response,Response::HTTP_OK);
        } catch (QueryException $e) {
            return response()->json([
                'message' =>"failed".$e->errorInfo
            ]);
        }
    }

}
