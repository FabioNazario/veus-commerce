<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->namespace('Api')->group(function(){

    Route::post('login','Auth\\LoginJwtController@login')->name('login');
    Route::get('logout','Auth\\LoginJwtController@logout')->name('logout');
    Route::get('refresh','Auth\\LoginJwtController@refresh')->name('refresh');

    Route::group(['middleware' => ['jwt.auth']], function () {

        Route::resource('products', 'ProductController');

    });


});
