<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class logRegistrasi extends Model
{
    use HasFactory;
    protected $fillable = ['nama','email','NamaPerushaan','PhoneNumber','RegisterDate'];
}
