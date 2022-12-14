<?php

namespace App\Models;

use App\Models\Iuran;
use App\Models\Cities;
use App\Models\Wilayah;
use App\Models\Pengurus;
use App\Models\Provinsi;
use App\Models\CompanyIndustry;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Member extends Model
{
    use HasFactory;
    protected $fillable = [
       
        'name',
        'email',
        'password',
        'username',
        'Email_verified_at',
        'Password',
        'NamaPerushaan',
        'PhoneNumber',
        'CompanyIndustryId',
        'WilayahId',
        'provinsiId',
        'KotaId',
        'BentukBadanUsaha',
        'AlasanBergabung',
        'alamat',
        'RegisterDate',
        'status',
        'roles',
        'gambar',

    ];
    public function Cities ()
    {
        return $this->belongsTo(Cities::class,'KotaId','id');
    }
    public function provinsi ()
    {
        return $this->belongsTo(Provinsi::class,'provinsiId','id');
    }
    public function iuran()
    {
        return $this->hasMany(Iuran::class);
    }
    // public function CompanyIndustry ()
    // {
    //     return $this->belongsTo(CompanyIndustry::class,'CompanyIndustryId','id');
    // }
   
    public function Wilayah ()
    {
        return $this->belongsTo(Wilayah::class,'WilayahId','id');
    }
    public function CompanyIndustry()
    {
    	return $this->belongsToMany(CompanyIndustry::class,'company_industry_members','member_id','CompanyIndustry_id');
    }
    public function pengurus()
    {
        return $this->hasMany(Pengurus::class);
    }
    
}
