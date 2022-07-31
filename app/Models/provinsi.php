<?php

namespace App\Models;

use App\Models\Cities;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class provinsi extends Model
{
    use HasFactory;
    use HasFactory;
    protected $fillable = ['name'];
    public function member()
    {
        return $this->hasMany(member::class);
    }
    public function register()
    {
        return $this->hasMany(register::class);
    }
    public function Cities()
    {
        return $this->hasMany(Cities::class);
    }
}
