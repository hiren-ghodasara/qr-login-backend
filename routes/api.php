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
Route::get('/get-qr-code', 'Api\AuthController@getQrCode')->name('user.get.qr'); // api/logout

Route::middleware('auth:api')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::get('/user-list', 'Api\AuthController@userList')->name('user.list'); // api/logou
    Route::post('/decode-qr', 'Api\AuthController@decodeQrCode')->name('user.decode.qr'); // api/logou
    Route::get('/logout', 'Api\AuthController@logout')->name('logout'); // api/logout
});
