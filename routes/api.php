<?php

use Illuminate\Http\Request;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/pagseguro/notification', ['as'=>'pagseguro_notification','uses' => 'PagSeguroController@request']);

Route::post('/check_qr_code', ['as'=>'check_qr_code', 'uses'=>'apiController@check_qr_code']);

Route::post('/retirar_ingressos', ['as'=>'retirar_ingressos', 'uses'=>'apiController@retirar_ingressos']);

Route::post('/lista_ingressos', ['as'=>'lista_ingressos', 'uses'=>'apiController@lista_ingressos']);