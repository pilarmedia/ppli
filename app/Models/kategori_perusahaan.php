<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kategori_perusahaan extends Model
{
    use HasFactory;
    public $table = "kategori_perushaan";
    protected $fillable = ['perusahaan_id','kategori_id'];

}
