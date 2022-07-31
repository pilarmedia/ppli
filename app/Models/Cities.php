<?php

namespace App\Models;

use App\Models\member;
use App\Models\register;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cities extends Model
{
    use HasFactory;
    protected $fillable = ['name','provinsiId'];
    public function member()
    {
        return $this->hasMany(member::class);
    }
    public function register()
    {
        return $this->hasMany(register::class);
    }
    public function provinsi()
    {
        return $this->belongsTo(provinsi::class,'provinsiId','id');
    }
}
