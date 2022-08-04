<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class khas extends Model
{
    use HasFactory;
    protected $fillable = ['kode_akun','nama','saldo_awal','saldo_akhir','keterangan','edit_by'];
}
