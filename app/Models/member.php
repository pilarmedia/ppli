<?php

namespace App\Models;

use App\Models\Cities;
use App\Models\Wilayah;
use App\Models\pengurus;
use App\Models\provinsi;
use App\Models\CompanyIndustry;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class member extends Model
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
        return $this->belongsTo(provinsi::class,'provinsiId','id');
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
        return $this->hasMany(pengurus::class);
    }
    
}
