<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyIndustry_register extends Model
{
    use HasFactory;
    public $table = "CompanyIndustry_register";
    protected $fillable = ['CompanyIndustry_id','register_id'];
}
