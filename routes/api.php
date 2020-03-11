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

    Route::get('users', 'v1\CheckUserController@check');

    Route::get('email/verify/{id}', 'v1\auth\VerificationController@verify')->name('api.verification.verify');
    Route::get('email/resend', 'v1\auth\VerificationController@resend')->name('api.verification.resend');
    Route::post('login', 'v1\auth\LoginController@login');
    Route::post('register', 'v1\auth\RegisterController@register');
    Route::post('password/email', 'v1\auth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('password/reset', 'v1\auth\ResetPasswordController@reset');

    Route::get('category', 'v1\CategoryController@index')->middleware(['auth:api', 'verified']);
    Route::post('category', 'v1\CategoryController@store')->middleware(['auth:api', 'verified']);
    Route::get('category/{category}', 'v1\CategoryController@show')->middleware(['auth:api', 'verified']);
    Route::post('category/{category}', 'v1\CategoryController@update')->middleware(['auth:api', 'verified']);
    Route::delete('category/{category}', 'v1\CategoryController@destroy')->middleware(['auth:api', 'verified']);

    Route::prefix('own')->group(function() {
        Route::get('store', 'v1\owner\StoreController@index')->middleware(['auth:api', 'verified']);
        Route::get('store/{store}', 'v1\owner\StoreController@show')->middleware(['auth:api', 'verified']);
        Route::post('store', 'v1\owner\StoreController@store')->middleware(['auth:api', 'verified']);
        Route::post('store/{store}', 'v1\owner\StoreController@update')->middleware(['auth:api', 'verified']);
        Route::delete('store/{store}', 'v1\owner\StoreController@destroy')->middleware(['auth:api', 'verified']);
    });
});
