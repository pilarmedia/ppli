<?php

namespace App\Models;

use App\Models\member;
use App\Models\register;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CompanyIndustry extends Model
{
    use HasFactory;
    public $table = "company_industries"; 
    protected $fillable = ['name'];
    // public function member()
    // {
    //     return $this->hasMany(member::class);
    // }
    // public function registers()
    // {
    //     return $this->hasMany(register::class);
    // }
    public function register()
    {
    	return $this->belongsToMany(register::class,'CompanyIndustry_register','CompanyIndustry_id','register_id');
    }
    public function member()
    {
    	return $this->belongsToMany(member::class,'company_industry_members','CompanyIndustry_id','member_id');
    }
}
