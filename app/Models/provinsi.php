<?php

namespace App\Models;

use App\Models\Cities;
use App\Models\Member;
use App\Models\Register;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Provinsi extends Model
{
  
    use HasFactory;
    protected $fillable = ['name'];
    public function member()
    {
        return $this->hasMany(Member::class);
    }
    public function register()
    {
        return $this->hasMany(Register::class);
    }
    public function Cities()
    {
        return $this->hasMany(Cities::class);
    }
}
