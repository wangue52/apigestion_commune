<?php
namespace App\Http\Controllers;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\BlocController;
use App\Http\Controllers\RentalController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::get('stores', [StoreController::class,'index']); 
Route::post('stores', [StoreController:: class,'store'])->name('boutique');
Route::get('stores/{store}', [StoreController::class,'show']);
Route::put('stores/{store}', [StoreController::class ,'update']);
Route::delete('stores/{store}', [StoreController:: class ,'destroy']);

    Route::get('blocs', [BlocController::class,'index']);
    Route::post('blocs', [BlocController::class,'store']);
    Route::get('blocs/{bloc}', [BlocController::class,'show']);
    Route::put('blocs/{bloc}', [BlocController::class,'update']);
    Route::delete('blocs/{bloc}', [BlocController::class,'destroy']);
    Route::prefix('rentals')->group(function () {
        Route::get('/', [RentalController::class, 'index']);
        Route::post('/', [RentalController::class, 'store']);
    });
    
