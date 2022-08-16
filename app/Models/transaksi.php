<?php

namespace App\Models;

use App\Models\Akun;
use App\Models\Khas;
use App\Models\Member;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaksi extends Model
{
    use HasFactory;
    protected $fillable = ['tanggal','KhasId','jenis_transaksi','AkunId','MemberId','keterangan','jumlah'];
    public function khas ()
    {
        return $this->belongsTo(Khas::class,'KhasId','id');
    }
    public function akun ()
    {
        return $this->belongsTo(Akun::class,'AkunId','id');
    }
    public function member ()
    {
        return $this->belongsTo(Member::class,'MemberId','id');
    }
}
