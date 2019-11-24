<?php

use Illuminate\Http\Request;

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

Route::post('/register', 'Api\AuthController@register');
Route::post('/login', 'Api\AuthController@login');
Route::get('/get-qr-code', 'Api\AuthController@getQrCode')->name('user.get.qr');
Route::any('/get-all-contest', 'Api\ContestController@listAllContest')->name('get.all.contest');
Route::get('/get-all-filters', 'Api\ContestController@setSideBarFilter')->name('get.all.filters');
Route::post('/test-create', 'Api\ContestController@TestCreate')->name('get.all.TestCreate');

//Route::get('/user-add-money', 'Api\AuthController@addMoneyWallet')->name('user.add.money');
//Route::get('/user-payment-methods', 'Api\AuthController@userAllPaymentMethods')->name('user.payment.list');

Route::middleware('auth:api')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::get('/user-list', 'Api\AuthController@userList')->name('user.list');
    //auth
    Route::post('/decode-qr', 'Api\AuthController@decodeQrCode')->name('user.decode.qr');
    Route::get('/logout', 'Api\AuthController@logout')->name('logout');
    //api token
    Route::get('/user-tokens', 'Api\AuthController@userAllApiTokens')->name('user.tokens');
    Route::get('/revoke-tokens', 'Api\AuthController@revokeApiTokens')->name('user.tokens.revoke');
    //transaction
    Route::get('/user-transactions', 'Api\AuthController@userAllTransactions')->name('user.transactions');
    //
    Route::get('/user-payment-methods', 'Api\AuthController@userAllPaymentMethods')->name('user.payment.list');
    Route::get('/user-payment-invoices', 'Api\AuthController@userAllInvoices')->name('user.invoices.list');
    Route::get('/user-payment-intent', 'Api\AuthController@userCreatePaymentMethodIntent')->name('user.payment.intent');
    Route::get('/user-add-money', 'Api\AuthController@addMoneyWallet')->name('user.add.money');
    Route::post('/add-payment-method', 'Api\AuthController@addPaymentMethod')->name('user.payment.add');
});
