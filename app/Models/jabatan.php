<?php

namespace App\Models;

use App\Models\pengurus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class jabatan extends Model
{
    use HasFactory;
    protected $fillable = ['name','level'];
    public function pengurus()
    {
        return $this->hasMany(pengurus::class);
    }
    
}
