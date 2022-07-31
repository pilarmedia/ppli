<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemplateMail extends Model
{
    use HasFactory; 
    protected $fillable = ['kode','tujuan','judul_email','isi_email'];
      }
