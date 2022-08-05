<?php

namespace App\Models;

use App\Models\mitra;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class tipeMitra extends Model
{
    use HasFactory;
    protected $fillable = ['name'];
    public function mitra()
    {
        return $this->hasMany(mitra::class);
    }
}
