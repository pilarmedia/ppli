<?php

namespace App\Models;

use App\Models\Member;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Iuran extends Model
{
    use HasFactory;
    protected $fillable =['memberId','bulan','jumlah','status','tanggal_bayar','tahun'];
    public function member ()
    {
        return $this->belongsTo(Member::class,'memberId','id');
    }
}
