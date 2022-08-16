<?php

namespace App\Models;

use App\Models\mitra;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class kontak extends Model
{
    use HasFactory;
    protected $fillable = ['nama','alamat','email','nomor','gambar','nama_perusahaan','status','agama','tanggal_lahir','no_ktp','npwp'];
    public function mitra()
    {
        return $this->hasMany(mitra::class);
    }
}
