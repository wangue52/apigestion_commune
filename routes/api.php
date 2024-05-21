<?php
namespace App\Http\Controllers;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\BlocController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\loginController;




Route::group(['prefix' => 'register'], function ()  {
    Route::post('/', [registerController::class, 'register']);
});

Route::group(['prefix' => 'api/v1/auth'], function () {
    Route::post('login', [LoginController::class, 'login']);
    Route::post('logout', [LoginController::class, 'logout']);
    Route::post('forgot-password', [LoginController::class, 'forgetPassword']);
});


Route::get('/user', function (Request $request) {
    return $request->user();
    Route::apiResource('users', UserController::class);
Route::post('users/upload-avatar/{id}', [UserController::class, 'uploadAvatar']);
Route::get('users/search/{query}', [UserController::class, 'search']);


})->middleware('auth:sanctum');
Route::get('stores', [StoreController::class,'index']); 
Route::post('stores', [StoreController:: class,'store']);
Route::get('stores/{id}', [StoreController::class,'show']);
Route::put('stores/{id}', [StoreController::class ,'update']);
Route::delete('stores/{id}', [StoreController:: class ,'destroy']);

Route::group(['prefix' => 'blocs'], function ()  {
    Route::get('/', [BlocController::class, 'index']);
    Route::post('/', [BlocController::class, 'bloc']);

    Route::get('/{bloc}', [BlocController::class, 'show']);
    Route::put('/{bloc}', [BlocController::class, 'update']);
    Route::delete('/{bloc}', [BlocController::class, 'destroy']);
}); 
    Route::prefix('rentals')->group(function () {
        Route::get('/', [RentalController::class, 'index']);
        Route::post('/', [RentalController::class, 'store']);
    });
Route::group(['prefix' => 'auth'], function () {
    Route::post('/login', [loginController::class, 'login']);
    Route::post('/forget-password', [loginController::class, 'forgetPassword']);
    Route::post('/logout', [loginController::class, 'logout']);
});
    
