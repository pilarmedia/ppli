<?php

namespace App\Models;

use App\Models\Mitra;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TipeMitra extends Model
{
    use HasFactory;
    protected $fillable = ['name'];
    public function mitra()
    {
        return $this->hasMany(Mitra::class);
    }
}
