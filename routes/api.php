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

    Route::get('test', 'TestFCMController@test');

    // update profile but no image
    Route::put('users/update', 'v1\UserController@updateProfile')->middleware(['auth:api', 'verified']);

    // update profile only image
    Route::post('users/image/update', 'v1\UserController@updateAvatar')->middleware(['auth:api', 'verified']);

    // notifications
    Route::get('notifications', 'v1\NotificationController@index')->middleware(['auth:api', 'verified']);

    Route::get('promo', 'v1\ProductController@get_promo')->middleware(['auth:api', 'verified']);
    Route::get('check/users', 'v1\CheckUserController@check');
    Route::post('report', 'v1\reports\ReportController@report')->middleware(['auth:api', 'verified']);
    Route::post('invoice', 'v1\reports\ReportController@invoice')->middleware(['auth:api', 'verified']);

    // discout by percent
    Route::patch('promo', 'v1\owner\ProductController@discount_by_percent')->middleware(['auth:api', 'verified']);

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

    // store for general
    Route::get('store', 'v1\StoreController@index')->middleware(['auth:api', 'verified']);
//    Route::get('store/{store}', 'v1\StoreController@show')->middleware(['auth:api', 'verified']);

    //product for general
    Route::get('product', 'v1\ProductController@search')->middleware(['auth:api', 'verified']);
    Route::get('product/{product}', 'v1\ProductController@show')->middleware(['auth:api', 'verified']);

    Route::get('users/profile','v1\ProfileController@index')->middleware(['auth:api', 'verified']);
    Route::get('user/{user}','v1\SearchBuyerController@show')->middleware(['auth:api', 'verified']);

    Route::get('search', 'v1\CheckUserController@search')->middleware(['auth:api', 'verified']);

    Route::get('search-buyer', 'v1\SearchBuyerController@search')->middleware(['auth:api', 'verified']);

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

    Route::post('/order/history', 'v1\OrderController@history')->middleware(['auth:api', 'verified']);

    Route::get('/product/{product}', 'v1\ProductController@show')->middleware(['auth:api', 'verified']);
    Route::get('/store/{store}', 'v1\StoreController@get_store')->middleware(['auth:api', 'verified']);

    Route::get('store_as_employee', 'v1\employee\EmployeeController@index')->middleware(['auth:api', 'verified']);

    Route::get('my_workplace', 'v1\employee\EmployeeController@my_workplace')->middleware(['auth:api', 'verified']);

    Route::prefix('own')->group(function() {
        Route::prefix('store')->group(function () {

            Route::get('', 'v1\owner\StoreController@index')->middleware(['auth:api', 'verified']);
//            Route::get('search', 'v1\owner\StoreController@search')->middleware(['auth:api', 'verified']);
            Route::get('{store}', 'v1\owner\StoreController@show')->middleware(['auth:api', 'verified']);
            Route::post('', 'v1\owner\StoreController@store')->middleware(['auth:api', 'verified']);
            Route::put('{store}', 'v1\owner\StoreController@update')->middleware(['auth:api', 'verified']);
            Route::post('{store}/logo/update', 'v1\owner\StoreController@updateStoreLogo')->middleware(['auth:api', 'verified']);
            Route::delete('{store}', 'v1\owner\StoreController@destroy')->middleware(['auth:api', 'verified']);

            // get invitation out by store
            Route::get('{store}/invitation/out', 'v1\owner\InvitationController@index')->middleware(['auth:api', 'verified']);

            Route::prefix('{store}/product')->group(function () {
                Route::get('', 'v1\owner\ProductController@index')->middleware(['auth:api', 'verified']);
                Route::get('search', 'v1\owner\ProductController@search')->middleware(['auth:api', 'verified']);
                Route::get('{product}', 'v1\owner\ProductController@show')->middleware(['auth:api', 'verified']);
                Route::post('', 'v1\owner\ProductController@store')->middleware(['auth:api', 'verified']);
                Route::put('{product}', 'v1\owner\ProductController@update')->middleware(['auth:api', 'verified']);
                Route::post('{product}/image/update', 'v1\owner\ProductController@updateImageProduk')->middleware(['auth:api', 'verified']);
                Route::delete('{product}', 'v1\owner\ProductController@destroy')->middleware(['auth:api', 'verified']);
            });

            Route::prefix('{store}/employee')->group(function () {
                Route::get('', 'v1\owner\EmployeeController@index')->middleware(['auth:api', 'verified']);
                Route::put('', 'v1\owner\EmployeeController@updateRole')->middleware(['auth:api', 'verified']);
                Route::delete('{employee}', 'v1\owner\EmployeeController@destroy')->middleware(['auth:api', 'verified']);
            });

        });
    });
});
