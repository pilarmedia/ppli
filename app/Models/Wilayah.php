<?php

namespace App\Models;

use App\Models\akun;
use App\Models\member;
use App\Models\register;
use App\Models\iuranAnggota;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Wilayah extends Model
{
    use HasFactory;
    protected $fillable = ['name','email','kota','alamat','nomor','HQ'];

    public function member()
    {
        return $this->hasMany(member::class);
    }
    public function iuranAnggota()
    {
        return $this->hasMany(iuranAnggota::class);
    }
    public function register()
    {
        return $this->hasMany(register::class);
    }
    public function akun()
    {
        return $this->hasMany(akun::class);
    }
    
    
}
