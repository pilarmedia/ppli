<?php

namespace App\Models;

use App\Models\Mitra;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kontak extends Model
{
    use HasFactory;
    protected $fillable = ['nama','alamat','email','nomor','longitude','latitude','gambar','logo','nama_perusahaan','status','agama','tanggal_lahir','no_ktp','npwp'];
    public function mitra()
    {
        return $this->hasMany(Mitra::class);
    }
}
