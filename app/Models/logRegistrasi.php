<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogRegistrasi extends Model
{
    use HasFactory;
    protected $fillable = ['nama','email','NamaPerushaan','PhoneNumber','RegisterDate'];
}
