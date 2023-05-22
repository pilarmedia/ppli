<?php

namespace App\Models;

use App\Models\Akun;
use App\Models\Member;
use App\Models\Register;
use App\Models\IuranAnggota;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Wilayah extends Model
{
    use HasFactory;
    // protected $fillable = ['name','email','kota','alamat','nomor','HQ'];
    public $guarded = [
        'id'
    ];

    public function member()
    {
        return $this->hasMany(Member::class);
    }
    public function iuranAnggota()
    {
        return $this->hasMany(IuranAnggota::class);
    }
    public function register()
    {
        return $this->hasMany(Register::class);
    }
    public function akun()
    {
        return $this->hasMany(Akun::class);
    }
    
    
}
