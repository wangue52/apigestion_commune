<?php
namespace App\Http\Controllers;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\BlocControler;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\loginController;
use GuzzleHttp\Client;


// Route::group(['prefix' => 'auth'], function ()  {
// Route::post('register', [registerController::class, 'register'])->name('register');
// Route::post('login', [registerController::class, 'login'])->name('login');
// Route::middleware(['auth:api'])->get('user', [registerController::class, 'user'])->name('user');
// Route::post('logout', [registerController::class, 'logout'])->name('logout');
// Route::post('upload-avatar/{id}', [registerController::class, 'uploadAvatar'])->name('uploadAvatar');
// Route::post('forgot-password', [registerController::class, 'forgetPassword']);
// ->middleware('auth:sanctum');
// });
Route::group(['prefix' => 'auth'], function ()  {
    Route::post('register', [registerController::class, 'register'])->name('register');
    Route::post('login', [registerController::class, 'login'])->name('login');
    Route::middleware(['auth:sanctum'])->get('user', [registerController::class, 'user'])->name('user');
    Route::post('logout', [registerController::class, 'logout'])->name('logout');
    Route::post('upload-avatar/{id}', [registerController::class, 'uploadAvatar'])->name('uploadAvatar');
    Route::post('forgot-password', [registerController::class, 'forgetPassword']);
});

Route::apiResource('users', UserController::class);
Route::post('users/upload-avatar/{id}', [UserController::class, 'uploadAvatar']);
Route::get('users/search/{query}', [UserController::class, 'search']);


Route::get('stores', [StoreController::class,'index']);
Route::post('stores', [StoreController:: class,'store']);

Route::get('stores/{id}', [StoreController::class,'show']);
Route::put('stores/{id}', [StoreController::class ,'update']);
Route::delete('stores/{id}', [StoreController:: class ,'destroy']);

Route::group(['prefix' => 'blocs'], function ()  {
    Route::get('/', [BlocControler::class, 'index']);
    Route::post('/', [BlocControler::class, 'stores']);

    Route::get('/{bloc}', [BlocControler::class, 'show']);
    Route::put('/{bloc}', [BlocControler::class, 'update']);
    Route::delete('bloc/{id}', [BlocControler::class, 'destroy']);
});
    Route::prefix('rentals')->group(function () {
        Route::get('/', [RentalController::class, 'index']);
        Route::post('/', [RentalController::class, 'store']);
    });
    Route::get('rental/qrcode/{data}', 'RentalController@getQrCodeData')->name('rental.qrcode');
    Route::get('rentals/{rental}/pdf', 'RentalController@generatePdf')->name('rentals.pdf');
