<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kegiatan extends Model
{
    use HasFactory;
    protected $fillable = ['nama_kegiatan','sifat_kegiatan','lokasi_kegiatan','tanggal_rencana','tanggal_realisasi','keterangan'];

}
