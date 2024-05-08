<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rental extends Model
{
    use HasFactory;
    protected $fillable = [
        'rental_id',
        'client_name',
        'store_matricule',
        'store_name',
        'store_address',
        'period_location',
        'rental_date',
        'price_store',


    ] ;
}
