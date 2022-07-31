<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyIndustry_member extends Model
{
    use HasFactory;
    // public $table = "CompanyIndustry_register";
    protected $fillable = ['CompanyIndustry_id','member_id'];
}
