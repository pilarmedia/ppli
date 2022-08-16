<?php

namespace App\Models;

use App\Models\Khas;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Laporan extends Model
{
    use HasFactory;
    protected $fillable = ['KhasId','kredit','debit','saldo_akhir'];
    public function khas ()
    {
        return $this->belongsTo(Khas::class,'KhasId','id');
    }
}
