<?php

namespace Database\Seeders;

use DateTime;
use App\Models\Akun;
use App\Models\Khas;
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
            'nama_akun'=>'iuran_anggota',
            'induk'=>false,
            'kategori_akun'=>'pemasukan'
          );
          $data3=array(
            'WilayahId'=>null,
            'kode'=>'102',
            'nama_kategori'=>'pendapatan',
            'nama_akun'=>'iuran dpp',
            'induk'=>false,
            'kategori_akun'=>'pemasukan'
          );
        //   dd($data);
    $akun=Akun::create($data1);
    $akun=Akun::create($data2);
    $akun=Akun::create($data3);
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
    $khas=Khas::create($data);
    $khas=Khas::create($data1);
    }
}
