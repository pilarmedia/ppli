<?php

namespace App\Models;

use App\Models\member;
use App\Models\kategori;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class perusahaan extends Model
{
    use HasFactory;
    protected $fillable = ['memberId','tahun_berdiri','path','title','profile','kategori'];
    public function kategori()
    {
    	return $this->belongsToMany(kategori::class);
    }
    public function member()
    {
    	return $this->belongsTo(member::class, 'memberId','id');
    }
}
