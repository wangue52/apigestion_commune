<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\LaravelPdf\Facades\Pdf;
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
    public function scopeWithStoreId($query, $storeId)
{
    return $query->where('store_id', $storeId);
}

public function scopeWithRentExpiration($query, $rentExpiration)
{
    return $query->where('rent_expiration', $rentExpiration);
}

public function scopeWithPaymentStatus($query, $paymentStatus)
{
    return $query->where('payment_status', $paymentStatus);
}
}
