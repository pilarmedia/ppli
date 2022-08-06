<?php

namespace App\Models;

use App\Models\Wilayah;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class iuranAnggota extends Model
{
    use HasFactory;
    protected $fillable =['WilayahId','bulan','iuran','setoran_DPP','tahun'];
    public function Wilayah ()
    {
        return $this->belongsTo(Wilayah::class,'WilayahId','id');
    }
}
