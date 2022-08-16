<?php

namespace App\Models;

use App\Models\Pengurus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Jabatan extends Model
{
    use HasFactory;
    protected $fillable = ['name','level'];
    public function pengurus()
    {
        return $this->hasMany(Pengurus::class);
    }
    
}
