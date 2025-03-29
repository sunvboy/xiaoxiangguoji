<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\customer\frontend\CustomerController;
use App\Http\Controllers\product\api\ProductController;

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('signup', [AuthController::class, 'signup']);
});
Route::group(['prefix' => 'auth', 'middleware' => 'auth:api'], function () {
    Route::delete('logout', [AuthController::class, 'logout']);
    Route::get('profile', [AuthController::class, 'profile']);
});

Route::post('/get-google-sign-in-url', [CustomerController::class, 'getGoogleSignInUrl']);
Route::get('/callback', [CustomerController::class, 'loginCallback']);