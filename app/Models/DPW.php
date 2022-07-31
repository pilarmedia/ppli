<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DPW extends Model
{
    use HasFactory;
    protected $fillable =['kode','nama','alamat_kantor','email','nomor'];
    
}
