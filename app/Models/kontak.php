<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kontak extends Model
{
    use HasFactory;
    protected $fillable = ['nama','alamat','email','nomor','status','agama','tanggal_lahir','no_ktp','npwp'];
}
