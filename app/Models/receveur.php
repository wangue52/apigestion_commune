<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class receveur extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'telephone',
        'motpasse',
        'adresse',
        'ville',
        'speudo',
        'photo',
    ];

    protected $hidden = [
        'motpasse',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];
    
}
