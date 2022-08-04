<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class email extends Model
{
    use HasFactory;
    protected $fillable =['name','email','port','host','email','username','password','encryption','receipt_subject','receipt_body'];
    
}
