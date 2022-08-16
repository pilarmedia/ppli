<?php

namespace App\Models;

use App\Models\Cities;
use App\Models\Wilayah;
use App\Models\Provinsi;

use App\Models\CompanyIndustry;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Register extends Model
{
    use HasFactory;
    protected $fillable = [
       
        'name',
        'email',
        'password',
        'Username',
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
        'status_DPP',
        'status_DPW',
        'RegisterDate',
        'status',
        'roles'
    ];
    public function Cities ()
    {
        return $this->belongsTo(Cities::class,'KotaId','id');
    }
    public function provinsi ()
    {
        return $this->belongsTo(Provinsi::class,'provinsiId','id');
    }
    // public function CompanyIndustrys ()
    // {
    //     return $this->belongsTo(CompanyIndustry::class,'CompanyIndustryId','id');
    // }
   
    public function Wilayah ()
    {
        return $this->belongsTo(Wilayah::class,'WilayahId','id');
    }
    public function CompanyIndustry()
    {
    	return $this->belongsToMany(CompanyIndustry::class,'CompanyIndustry_register','register_id','CompanyIndustry_id');
    }
}
