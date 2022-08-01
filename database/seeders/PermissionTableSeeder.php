<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'kegiatan-index',
            'kegiatan-store',
            'kegiatan-update',
            'kegiatan-show',
            'kegiatan-delete',
            'pengurus-index',
            'pengurus-store',
            'pengurus-update',
            'pengurus-show',
            'pengurus-delete',
            'provinsi-index',
           'provinsi-store',
           'provinsi-update',
           'provinsi-show',
           'provinsi-delete',
           'dpw-index',
           'dpw-store',
           'dpw-update',
           'dpw-show',
           'dpw-delete',
           'cities-index',
           'cities-store',
           'cities-update',
           'cities-show',
           'cities-delete',
           'jabatan-index',
           'jabatan-store',
           'jabatan-update',
           'jabatan-show',
           'jabatan-delete',
           'kategori-index',
           'kategori-store',
           'kategori-update',
           'kategori-show',
           'kategori-delete',
           'statusRegister-index',
           'statusRegister-store',
           'statusRegister-update',
           'statusRegister-show',
           'statusRegister-delete',
           'wilayah-index',
           'wilayah-store',
           'wilayah-update',
           'wiilayah-show',
           'wilayah-delete',
        //    'email-index',
        //    'email-store',
        //    'email-update',
        //    'email-show',
        //    'email-delete',
           'kontak-index',
           'kontak-store',
           'kontak-update',
           'kontak-show',
           'kontak-delete',
           'indutry-index',
           'industry-store',
           'industry-update',
           'industry-show',
           'industry-delete',
           'register-index',
              
        ];
        foreach ($permissions as $permission) {
            Permission::create([
                'name' => $permission,
            ]);
        }
    }
}
