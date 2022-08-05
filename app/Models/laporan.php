<?php

namespace App\Models;

use App\Models\khas;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class laporan extends Model
{
    use HasFactory;
    protected $fillable = ['KhasId','kredit','debit','saldo_akhir'];
    public function khas ()
    {
        return $this->belongsTo(khas::class,'KhasId','id');
    }
}
