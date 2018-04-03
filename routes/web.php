<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', ['as'=>'index_route','uses' => 'admController@index']);
Route::get('/ajuda', ['as'=>'help','uses' => 'admController@help']);
Route::get('/termosdeuso', ['as'=>'termosdeuso','uses' => 'admController@termosdeuso']);
Route::post('/contato', ['as'=>'contato','uses' => 'admController@contato']);

Route::post('/pagseguro/transparente', ['as'=>'pagseguro.transparente.getCode','uses' => 'PagSeguroController@pagseguro_transparente_getCode'])->middleware('auth');

Route::post('/pagseguro/transparente/cartao-credito', ['as'=>'pagseguro.transparente.cartao-credito','uses' => 'PagSeguroController@pagseguro_transparente_cartaocredito'])->middleware('auth');


Route::get('/carrinho', ['as'=>'ver_carrinho','uses' => 'admController@carrinho_index'])->middleware('auth');
Route::get('/carrinho/remover', ['as'=>'remover_carrinho','uses' => 'admController@remover_carrinho'])->middleware('auth');
Route::get('/checkout', ['as'=>'pagseguro.transparente','uses' => 'PagSeguroController@pagseguro_transparente'])->middleware('auth');


Route::get('/qr_code', ['as'=>'qr_code_generator','uses' => 'admController@qr_code_generator'])->middleware('auth');

Route::post('/comprar', ['as'=>'comprar','uses' => 'admController@comprar']);
Route::get('/comprar', ['as'=>'comprar_get','uses' => 'admController@comprar_get'])->middleware('auth');


Route::get('/meuspedidos', ['as'=>'meuspedidos','uses' => 'admController@meuspedidos'])->middleware('auth');
Route::get('/meusdados', ['as'=>'meusdados','uses' => 'admController@meusdados'])->middleware('auth');
Route::post('edita_meusdados_inline/{campo}/{id_user}', ['as'=>'adm.edita_meusdados_inline', 'uses' => 'admController@edita_meusdados_inline']);

Route::post('/checkout/finalizar_checkout/aAl7yeussXpDGYOYemONtXGDPdcMEc5A1LRwYJ9pFCWMPcH80u', ['as'=>'finalizar_checkout','uses' => 'admController@grava_checkout'])->middleware('auth');


Route::get('/checkout/aAl7yeussXpDwYJ9pFCWMPcH80uaAl7ynao8w9qvai99szoar0a909o09aijsdroleeussXpDGYOYemONtXGcMEc5A1LRwYJ9pFCWMPcH80uaAl7yeussXpDGYOYemONtXGDPdwYJ9pFCWMPcH80uknjsoas0a02/compraconcluida', ['as'=>'congrats','uses' => 'admController@congrats'])->middleware('auth');

Route::post('/ver_voucher', ['as'=>'baixavoucher', 'uses' => 'admController@baixa_voucher'])->middleware('auth');

Route::get('/ver_voucher/{ref_num}/{token}', ['as'=>'baixavoucher_email', 'uses' => 'admController@baixa_voucher_email']);

Route::get('/vouchers/{ref}/{pdf}',['as'=>'block_route', 'uses' => 'admController@block_route'])->middleware('auth');

Route::get('/testaenviodeemailahuahiahuahu',['as'=>'testa_envio_mail', 'uses' => 'admController@testemail'])->middleware('auth');


Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix'=>'adm', 'middleware'=>['auth','authAdm']],function (){
	Route::get('/precos', ['as'=>'adm_lista_precos','uses' => 'admController@precos_index']);
	Route::get('/precos/salva/{string_salvar}', ['as'=>'adm_salva_precos','uses' => 'admController@salva_precos']);
	Route::get('/precos/delete/{id_preco}', ['as'=>'adm_salva_precos','uses' => 'admController@deleta_precos']);
	Route::get('/precos/loteatual/{tipo}/{num_lote}', ['as'=>'adm_salva_loteatual','uses' => 'admController@salva_lote_atual']);
	Route::post('edita_preco_inline/{id_preco}', ['as'=>'adm.edita_preco_inline', 'uses' => 'admController@edita_preco_inline']);

	Route::get('/pedidos', ['as'=>'adm_lista_pedidos','uses' => 'admController@pedidos_index']);
	Route::get('/usuarios', ['as'=>'adm_lista_usuarios','uses' => 'admController@usuarios_index']);

});


