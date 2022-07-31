<?php

namespace App\Models;

use App\Models\member;
use App\Models\jabatan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class pengurus extends Model
{
    use HasFactory;
    protected $fillable = ['jabatanId','memberId','username','status'];
    public function jabatan()
    {
        return $this->belongsTo(jabatan::class,'jabatanId','id');
    }
    public function member()
    {
        return $this->belongsTo(member::class,'memberId','id');
    }
}
