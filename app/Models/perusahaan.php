<?php

namespace App\Models;

use App\Models\Member;
use App\Models\Kategori;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Perusahaan extends Model
{
    use HasFactory;
    protected $fillable = ['memberId','tahun_berdiri','path','title','profile','kategori'];
    public function kategori()
    {
    	return $this->belongsToMany(Kategori::class);
    }
    public function member()
    {
    	return $this->belongsTo(Member::class, 'memberId','id');
    }
}
