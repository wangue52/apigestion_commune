<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class agent extends User
{
    use HasFactory;
    protected $fillable = [
        'nom',
        'prenom',
        'tel',
        'adresse',
        'email',
        'password',
    ];
}
