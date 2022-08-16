<?php

namespace App\Models;

use App\Models\Kontak;
use App\Models\TipeMitra;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mitra extends Model
{
    use HasFactory;
    protected $fillable = ['kontakId','tipe_mitra','tanggal_bergabung','tanggal_bergabung','deskripsi'];
    public function kontak()
    {
        return $this->belongsTo(Kontak::class,'kontakId','id');
    }
    public function tipeMitra()
    {
        return $this->belongsTo(TipeMitra::class,'tipe_mitra','id');
    }
}
