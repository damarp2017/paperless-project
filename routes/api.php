<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {
    Route::get('email/verify/{id}', 'v1\auth\VerificationController@verify')->name('api.verification.verify');
    Route::get('email/resend', 'v1\auth\VerificationController@resend')->name('api.verification.resend');
    Route::post('login', 'v1\auth\LoginController@login');
    Route::post('register', 'v1\auth\RegisterController@register');
});
