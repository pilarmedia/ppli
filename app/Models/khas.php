<?php

namespace App\Models;

use App\Models\akun;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class khas extends Model
{
    use HasFactory;
    protected $fillable = ['kode','kode_akun','nama','saldo_awal','saldo_akhir','keterangan','edit_by'];
    public function akun ()
    {
        return $this->belongsTo(akun::class,'kode_akun','id');
    }
}
