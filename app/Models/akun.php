<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class akun extends Model
{
    use HasFactory;
    protected $fillable = ['WilayahId','kode','nama_kategori','nama_akun','induk','kategori_akun'];
}
