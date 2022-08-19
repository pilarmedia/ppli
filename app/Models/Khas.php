<?php

namespace App\Models;

use App\Models\Akun;
use App\Models\Laporan;
use App\Models\Transaksi;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Khas extends Model
{
    use HasFactory;
    protected $fillable = ['kode','kode_akun','nama','saldo_awal','saldo_akhir','keterangan','tanggal','edit_by'];
    public function akun ()
    {
        return $this->belongsTo(Akun::class,'kode_akun','id');
    }
    public function laporan()
    {
        return $this->hasMany(Laporan::class);
    }
    public function transaksi()
    {
        return $this->hasMany(Transaksi::class);
    }
}
