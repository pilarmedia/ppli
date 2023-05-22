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

    public $guarded = [
        'id'
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
