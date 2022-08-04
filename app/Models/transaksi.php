<?php

namespace App\Models;

use App\Models\akun;
use App\Models\khas;
use App\Models\member;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class transaksi extends Model
{
    use HasFactory;
    protected $fillable = ['tanggal','KhasId','jenis_transaksi','AkunId','MemberId','keterangan','jumlah'];
    public function khas ()
    {
        return $this->belongsTo(khas::class,'khasId','id');
    }
    public function akun ()
    {
        return $this->belongsTo(akun::class,'AkunId','id');
    }
    public function member ()
    {
        return $this->belongsTo(member::class,'MemberId','id');
    }
}
