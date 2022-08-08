<?php

namespace App\Models;

use App\Models\akun;
use App\Models\laporan;
use App\Models\transaksi;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class khas extends Model
{
    use HasFactory;
    protected $fillable = ['kode','kode_akun','nama','saldo_awal','saldo_akhir','keterangan','tanggal','edit_by'];
    public function akun ()
    {
        return $this->belongsTo(akun::class,'kode_akun','id');
    }
    public function laporan()
    {
        return $this->hasMany(laporan::class);
    }
    public function transaksi()
    {
        return $this->hasMany(transaksi::class);
    }
}
