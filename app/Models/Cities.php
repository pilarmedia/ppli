<?php

namespace App\Models;

use App\Models\Member;
use App\Models\Register;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cities extends Model
{
    use HasFactory;
    protected $fillable = ['name','provinsiId'];
    public function member()
    {
        return $this->hasMany(Member::class);
    }
    public function register()
    {
        return $this->hasMany(Register::class);
    }
    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class,'provinsiId','id');
    }
}
