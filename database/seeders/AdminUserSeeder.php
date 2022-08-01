<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user=User::create([
            'name'=>'admin',
            'password'=>Hash::make('12345678'),
            'email'=>'admin@gmail.com',
            'username'=>'admin',
            'roles'=>'admin'
        ]);
        Role::create([
            'name' => 'admin',
        ]);
        Role::create([
            'name' => 'member',
        ]);
        $id_permission=array();
        for($i=1;$i<=56;$i++){
           array_push($id_permission,$i);
        }
        foreach ($id_permission as $permission) {
            DB::table('role_has_permissions')->insert([
                'permission_id' => $permission,
                'role_id' => 1,
            ]);
        }
        foreach ($id_permission as $permission) {
            DB::table('model_has_permissions')->insert([
                'permission_id' => $permission,
                'model_id' => 1,
                'model_type' => 'App\Models\User',
            ]);
        }
            // DB::table('role_has_permissions')->insert([
                
            // ]);
    }
}
