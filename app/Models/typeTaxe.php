<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class typeTaxe extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom',
        'taux',
        'description',
        'status',
        'created_at',
    ] ;
}
