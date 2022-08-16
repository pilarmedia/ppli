<?php

namespace App\Models;

use App\Models\Member;
use App\Models\Jabatan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pengurus extends Model
{
    use HasFactory;
    protected $fillable = ['jabatanId','memberId','username','status'];
    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class,'jabatanId','id');
    }
    public function member()
    {
        return $this->belongsTo(Member::class,'memberId','id');
    }
}
