<?php

namespace App\Models;

use App\Models\member;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class iuran extends Model
{
    use HasFactory;
    protected $fillable =['memberId','bulan','jumlah','status','tanggal_bayar','tahun'];
    public function member ()
    {
        return $this->belongsTo(member::class,'memberId','id');
    }
}
