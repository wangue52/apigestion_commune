<?php
namespace App\Http\Controllers;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\BlocController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\loginController;
use GuzzleHttp\Client;




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
    Route::get('rental/qrcode/{data}', 'RentalController@getQrCodeData')->name('rental.qrcode');
    // Route::get('location', function (Request $request) {
    //     $ipAddress = $request->ip();
    
    //     $client = new Client();
    //     $response = $client->get('https://ipinfo.io/' . $ipAddress, [
    //         'headers' => [
    //             'X-API-KEY' => env('ipinfo.io/[IP address]?token=20de5a57df4785'),
    //         ],
    //     ]);
    
    //     $locationData = json_decode($response->getBody()->getContents());
    
    //     return response()->json([
    //         'latitude' => $locationData->loc->lat,
    //         'longitude' => $locationData->loc->lon,
    //     ]);
    // });
