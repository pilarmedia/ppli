<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class roleController extends Controller
{
    public function index()
    {
        $data = Role::get();
        $response = [
            'message' => 'show role ',
            'data' => $data
        ];
        return response()->json($response, Response::HTTP_CREATED);
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $role = Role::create([
            'name' => $request->name,
            'guard_name' => 'api'
        ]);

        $response = [
            'message' => 'add succes ',
            'data' => $role
        ];
        return response()->json($response, Response::HTTP_CREATED);
    }

    public function storePermission(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $role = Permission::create([
            'name' => $request->name,
            'guard_name' => 'api'
        ]);

        $response = [
            'message' => 'add succes ',
            'data' => $role
        ];
        return response()->json($response, Response::HTTP_CREATED);
    }

    public function showPermission()
    {
        $data = Permission::all();
        $response = [
            'message' => 'show succes ',
            'data' => $data
        ];
        return response()->json($response, Response::HTTP_CREATED);
    }
    public function updateRolePermission(Request $request, $id)
    {
        $role = Role::find($id);
        try {
            $role->syncPermissions($request->permission);
            $response = [
                'message' => 'update succes',
            ];
            return response()->json($response, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            $response = [
                'message' => 'update gagal',
            ];
            return response()->json($response, Response::HTTP_CREATED);
        }
    }
    public function show_has($id)
    {
        // dd($id);
        $has_permission = DB::table('role_has_permissions')->leftJoin('permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')->where('role_id', $id)->get();

        $count = count($has_permission);
        $data = [];
        for ($i = 0; $i < $count; $i++) {
            array_push($data, $has_permission[$i]->name);
        }
        // dd($data);
        $response = [
            'message' => 'show succes ',
            'data' => $has_permission
        ];
        return response()->json($response, Response::HTTP_CREATED);
    }

    public function update_user_permission(Request $request, $id)
    {
        $user = User::find($id);
        $user->syncPermissions($request->permission);
        $response = [
            'message' => 'show succes ',
            'data' => $user
        ];
        return response()->json($response, Response::HTTP_CREATED);
    }
    public function show_permission_user(Request $request, $id)
    {
        $permission = DB::table('model_has_permissions')->leftJoin('permissions', 'permissions.id', '=', 'model_has_permissions.permission_id')->where('model_id', $id)->get();
        $response = [
            'message' => 'show succes ',
            'data' => $permission
        ];
        return response()->json($response, Response::HTTP_CREATED);
    }
    public function permission_user($id)
    {

        $data = array();
        $permission = Permission::get();
        $has_permission = DB::table('model_has_permissions')->where('model_id', $id)->get();
        foreach ($permission as $item) {
            $conidition = true;
            foreach ($has_permission as $permission) {
                if ($item->id === $permission->permission_id) {
                    $data[] = [
                        'permission_id' => $permission->permission_id,
                        'model_id' => $id,
                        'permission_name' => $item->name,
                        'has_permission' => true,
                    ];
                    $conidition = false;
                    continue;
                }
            }
            if ($conidition !== false) {
                $data[] = [
                    'permission_id' => $item->id,
                    'model_id' => $id,
                    'permission_name' => $item->name,
                    'has_permission' => false,
                ];
            }
        }
        return response()->json($data, 200);
    }
    public function addUser(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'Username' => 'required',
            'roles' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(
                $validator->errors(),
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }
        
            $data = array(
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'Username' => $request->Username,
                'roles' => $request->roles
            );
            $user = user::create($data);
            $token = Auth::login($user);
            $roles = Role::where('name', $request->roles)->first();
            $has_permission = DB::table('role_has_permissions')
                ->leftJoin('permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
                ->where('role_id', $roles->id)->get();
            $result = [];
            foreach ($has_permission as $item) {
                $result[] = $item->name;
            }
            $user->syncPermissions($result);
            return response()->json([
                'status' => 'success',
            ]);
    }
    public function updateroleUser(Request $request, $id)
    {
        $user = user::find($id);
        try {
            $roles = Role::where('name', $request->roles)->first();
            $has_permission = DB::table('role_has_permissions')->leftJoin('permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')->where('role_id', $roles->id)->get();
            $result = [];
            foreach ($has_permission as $item) {
                $result[] = $item->name;
            }

            $user->syncPermissions($result);
            $user->roles = $request->roles;
            $user->save();
            return response()->json([
                'status' => 'success',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'gagal',
            ]);
        }
    }
    public function deleteUser($id)
    {
        $user = user::find($id);
        $user->delete();
        DB::table('model_has_permissions')->where('model_id', $user->id)->delete();
    }
    public function permission_role($id)
    {
        $data = array();
        $permission = Permission::get();
        $has_permission = DB::table('role_has_permissions')->where('role_id', $id)->get();
        foreach ($permission as $item) {
            $conidition = true;
            foreach ($has_permission as $permission) {
                if ($item->id === $permission->permission_id) {
                    $data[] = [
                        'permission_id' => $permission->permission_id,
                        'role_id' => $id,
                        'permission_name' => $item->name,
                        'has_permission' => true,
                    ];
                    $conidition = false;
                    continue;
                }
            }
            if ($conidition !== false) {
                $data[] = [
                    'permission_id' => $item->id,
                    'role_id' => $id,
                    'permission_name' => $item->name,
                    'has_permission' => false,
                ];
            }
        }
        return response()->json($data, 200);
    }
    public function showUser($id){
        $user=user::find($id);
        $data=$user->roles;
        return response()->json([$data,200]);
    }
    public function delete_role($id){
        $role=Role::find($id);
        $role->delete();
        DB::table('role_has_permissions')->where('role_id',$id)->delete();
        return response()->json('succes delete', 200);
    }
    public function showRole($id){
        $roles=user::find($id);
        return response()->json($roles,200);
    }
}
