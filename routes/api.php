<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiAuthController;
use App\Http\Controllers\Blade\ApiUserController;
use App\Http\Controllers\Pages\BrandController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/
Route::middleware('apicheck')->post('/v1/gw','\App\Http\Controllers\Api\V1\MainController@index');

# Api Clients
Route::post('/login',[ApiAuthController::class,'login']);

Route::group(['middleware' => 'api-auth'],function (){
    Route::post('/me',[ApiAuthController::class,'me']);
    Route::post('/tokens',[ApiAuthController::class,'getAllTokens']);
    Route::post('/logout',[ApiAuthController::class,'logout']);
});

Route::group(['middleware' => 'ajax.check'],function (){
    Route::post('/api-user/toggle-status/{user_id}',[ApiUserController::class,'toggleUserActivation']);
    Route::post('/api-token/toggle-status/{token_id}',[ApiUserController::class,'toggleTokenActivation']);
});


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//Route::post('/account/createAccCard', 'AccountController@createAccCard')->name('createAccCard');
Route::post('/getBrand', 'App\Http\Controllers\Pages\BrandController@getBrand')->name('getBrand');
