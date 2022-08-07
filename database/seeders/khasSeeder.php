<?php

namespace Database\Seeders;

use App\Models\akun;
use App\Models\khas;
use Illuminate\Database\Seeder;

class khasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data1=array(
            'WilayahId'=>null,
            'kode'=>'1',
            'nama_akun'=>'pendapatan',
            'induk'=>true,
            'kategori_akun'=>'pemasukan'
          );
          $data2=array(
            'WilayahId'=>null,
            'kode'=>'101',
            'nama_kategori'=>'pendapatan',
            'nama_akun'=>'iuran',
            'induk'=>false,
            'kategori_akun'=>'pemasukan'
          );
        //   dd($data);
    $akun=akun::create($data1);
    $akun=akun::create($data2);
        $data=array(
            'kode'=>'01',
            'nama'=>'iuran',
            'kode_akun'=>'2',
            'saldo_awal'=>0,
            'saldo_akhir'=>0,
            'keterangan'=>'iuran',
            'edit_by'=>'admin',
          );
        //   dd($data);
    $khas=khas::create($data);
    }
}
