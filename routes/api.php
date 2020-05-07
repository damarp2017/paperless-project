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

    Route::get('check/users', 'v1\CheckUserController@check');

    Route::get('email/verify/{id}', 'v1\auth\VerificationController@verify')->name('api.verification.verify');
    Route::get('email/resend', 'v1\auth\VerificationController@resend')->name('api.verification.resend');
    Route::post('login', 'v1\auth\LoginController@login');
    Route::post('register', 'v1\auth\RegisterController@register');
    Route::post('password/email', 'v1\auth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('password/reset', 'v1\auth\ResetPasswordController@reset');

    Route::get('category', 'v1\CategoryController@index');
    Route::post('category', 'v1\CategoryController@store');
    Route::get('category/{category}', 'v1\CategoryController@show');
    Route::post('category/{category}', 'v1\CategoryController@update');
    Route::delete('category/{category}', 'v1\CategoryController@destroy');

    Route::get('users/profile','v1\ProfileController@index')->middleware(['auth:api', 'verified']);

    Route::get('search', 'v1\CheckUserController@search');

    Route::get('search-buyer', 'v1\SearchBuyerController@search');

    // Invitation out
    Route::post('invitation/out', 'v1\owner\InvitationController@invite')->middleware(['auth:api', 'verified']);

    // Invitation in
    Route::get('invitation/in', 'v1\InvitationController@index')->middleware(['auth:api', 'verified']);

    // Accept Invitation In
    Route::get('invitation/in/{invitation}/accept', 'v1\InvitationController@accept')->middleware(['auth:api', 'verified']);

    // Reject Invitation In
    Route::get('invitation/in/{invitation}/reject', 'v1\InvitationController@reject')->middleware(['auth:api', 'verified']);


    // test order
    Route::post('/order', 'v1\OrderController@store')->middleware(['auth:api', 'verified']);

    Route::prefix('own')->group(function() {
        Route::prefix('store')->group(function () {
            Route::get('', 'v1\owner\StoreController@index')->middleware(['auth:api', 'verified']);
            Route::get('search', 'v1\owner\StoreController@search')->middleware(['auth:api', 'verified']);
            Route::get('{store}', 'v1\owner\StoreController@show')->middleware(['auth:api', 'verified']);
            Route::post('', 'v1\owner\StoreController@store')->middleware(['auth:api', 'verified']);
            Route::post('{store}', 'v1\owner\StoreController@update')->middleware(['auth:api', 'verified']);
            Route::delete('{store}', 'v1\owner\StoreController@destroy')->middleware(['auth:api', 'verified']);

            // get invitation out by store
            Route::get('{store}/invitation/out', 'v1\owner\InvitationController@index')->middleware(['auth:api', 'verified']);

            Route::prefix('{store}/product')->group(function () {
                Route::get('', 'v1\owner\ProductController@index')->middleware(['auth:api', 'verified']);
                Route::get('search', 'v1\owner\ProductController@search')->middleware(['auth:api', 'verified']);
                Route::get('{product}', 'v1\owner\ProductController@show')->middleware(['auth:api', 'verified']);
                Route::post('', 'v1\owner\ProductController@store')->middleware(['auth:api', 'verified']);
                Route::post('{product}', 'v1\owner\ProductController@update')->middleware(['auth:api', 'verified']);
                Route::delete('{product}', 'v1\owner\ProductController@destroy')->middleware(['auth:api', 'verified']);
            });

        });
    });
});
