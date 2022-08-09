<?php

namespace Database\Seeders;

use DateTime;
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
    date_default_timezone_set('Asia/Jakarta');
            $ldate = new DateTime('now');
        $data=array(
            'kode'=>'01',
            'nama'=>'iuran anggota',
            'kode_akun'=>'2',
            'saldo_awal'=>0,
            'saldo_akhir'=>0,
            'keterangan'=>'iuran anggota',
            'tanggal'=>$ldate,
            'edit_by'=>'admin',
          );
          $data1=array(
            'kode'=>'02',
            'nama'=>'iuran dpp',
            'kode_akun'=>'2',
            'saldo_awal'=>0,
            'saldo_akhir'=>0,
            'keterangan'=>'iuran dpp',
            'tanggal'=>$ldate,
            'edit_by'=>'admin',
          );
        //   dd($data);
    $khas=khas::create($data);
    $khas=khas::create($data1);
    }
}
