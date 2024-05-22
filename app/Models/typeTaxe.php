<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class typeTaxe extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom',
        'taux',
        'description',
    ] ;
    public function taxe(){
        return $this->BelongsTo(taxe::class);
    }
}
