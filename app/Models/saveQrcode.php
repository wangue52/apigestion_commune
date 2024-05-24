<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class saveQrcode extends Model
{
    use HasFactory;
    protected $fillable = ['data', 'qrcode_url', ];
}
