<?php

namespace App\Http\Controllers;

use DateTime;
use App\Models\User;
use App\Models\register;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','user','register']]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $credentials = $request->only('email', 'password');

        $token = Auth::attempt($credentials);
        // $user=User::where('email',$request->email)->first();
        // $user->remember_token=$token;
        // $user->save();
        // dd($token);
        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 401);
        }

        $user = Auth::user();
        $permission= DB::table('model_has_permissions')->leftJoin('permissions', 'permissions.id', '=', 'model_has_permissions.permission_id')->where('model_id', $user->id)->get();
       
        $result[0] = 'home';
        $result[1] = 'pengaturan';
        foreach ($permission as $item) {
            $result[] = $item->name;
        }
        // $wilayah_permission=register::where('WilayahId',$user->WilayahId)->first();
        return response()->json([
                'status' => 'success',
                'user' => $user,
                'permission' =>$result,
                // 'wilayah'=>$wilayah_permission->WilayahId,
                'authorisation' => [
                    'token' => $token,
                    'type' => 'bearer',
                ]
            ]);

    }

    public function userProfile() {
        return response()->json(auth()->user());
    }

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }

    public function refresh()
    {
        return response()->json([
            'status' => 'success',
            'user' => Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }
    public function user(){
        $data=User::all();
        foreach ($data as $item) {
            $conidition = true;
            
            if(($item->id == '1' )){
                $roles[] = [
                    'id'=>$item->id,
                    'name'=>$item->name,
                    'cekRoles'=>false
                ];
            } else{
                $roles[] = [
                    'id'=>$item->id,
                    'name'=>$item->name,
                    'cekRoles'=>true
                ];
            }
        }
        return response()->json([
            'data'=>$user
        ]);
    }
}
