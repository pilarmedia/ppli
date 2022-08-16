<?php

namespace App\Models;

use App\Models\perusahaan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kategori extends Model
{
    use HasFactory;
    protected $fillable = ['name'];
    public function perusahaan()
    {
    	return $this->belongsToMany(perusahaan::class);
    }
}
