<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class perusahaan_kategori extends Model
{
    use HasFactory;
    protected $fillable = ['perusahaanId','kategoriId'];
}
