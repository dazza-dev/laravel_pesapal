<?php

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Bryceandy\Laravel_Pesapal\Http\Controllers'], function(){

    Route::post('pesapal/iframe', 'PaymentController@store');

    Route::get('callback', 'PaymentController@callback');
});
