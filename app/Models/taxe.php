<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class taxe extends Model
{
    use HasFactory;
    protected $fillable=[
        'nom' ,


    ] ;
    public function typeTaxe(){
        return $this->belongsTo(typeTaxe::class);
    }
}
