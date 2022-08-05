<?php

namespace App\Models;

use App\Models\kontak;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class mitra extends Model
{
    use HasFactory;
    protected $fillable = ['kontakId','tipe_mitra','tanggal_bergabung','tanggal_bergabung','deskripsi'];
    public function kontak()
    {
        return $this->belongsTo(kontak::class,'kontakId','id');
    }
}
