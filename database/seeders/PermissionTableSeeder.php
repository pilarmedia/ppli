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
            'wilayah-index',
            'wilayah-add',
            'wilayah-edit',
            'wilayah-delete',
            'city-index',
            'city-add',
            'city-edit',
            'city-delete',
            'provinsi-index',
            'provinsi-add',
            'provinsi-edit',
            'provinsi-delete',
            'industri-index',
            'industri-add',
            'industri-edit',
            'industri-delete',
            'bank-index',
            'bank-add',
            'bank-edit',
            'bank-delete',
            'tipemitra-index',
            'tipemitra-add',
            'tipemitra-edit',
            'tipemitra-delete',
            'settingemail-index',
            'pengurus-index',
            'pengurus-add',
            'pengurus-edit',
            'pengurus-delete',
            'jabatan-index',
            'jabatan-add',
            'jabatan-edit',
            'jabatan-delete',
            'kategori-index',
            'kategori-add',
            'kategori-edit',
            'kategori-delete',
            'daftarkas-index',
            'daftarkas-add',
            'daftarkas-edit',
                'usermanagement-index',
                'usermanagement-add',
                'usermanagement-edit-role',
                'usermanagement-privilege',
                'usermanagement-delete',
                'group-index',
                'group-add',
                'group-privilege',
                'group-delete',
                'register-index',
                'register-show',
                'register-delete',
                'logregister-index',
                'member-index',
                'member-show',
                'member-edit',
                'member-edit-foto',
                'member-transaksi-index',
                'member-iuran-index',
                'member-iuran-edit',
            'mitra-index',
            'mitra-add',
            'mitra-edit',
            'mitra-delete',
            'iuran-index',
            'transaksi-index',
            'transaksi-add',
            'transaksi-edit',
            'transaksi-delete',
            'transaksi-rekap-index',
            'transaksi-laporan-index',
            'kontak-index',
            'kontak-add',
            'kontak-show',
            'kontak-edit',
            'kontak-delete',
            'kontak-kartunama',
            'kegiatan-index',
            'kegiatan-add',
            'kegiatan-edit',
            'kegiatan-delete',
            'pengumuman-index',
            'pengumuman-add',
            'pengumuman-show',
            'pengumuman-edit',
            'pengumuman-delete',

                
        ];
        foreach ($permissions as $permission) {
            Permission::create([
                'name' => $permission,
            ]);
        }
    }
}
