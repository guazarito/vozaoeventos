<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PagSeguro;
use App\Cart;
use Auth;
use App\Order;
use App\User;
use App\Notifications\VozaoNotify;

class PagSeguroController extends Controller
{



	public function pagseguro_transparente(){
		$cart = new Cart;
		$items = $cart->getItems();
		$total_carrinho =  $cart->getTotal();
		$taxa = ($total_carrinho*(float)(config('pagseguro.taxa')));

		$total_com_taxa = $total_carrinho + $taxa;
		$total_com_taxa = number_format($total_com_taxa,2);

		$user_cpf = Auth::user()->cpf;
		$user_cpf = str_replace(".", "", $user_cpf);
		$user_cpf = str_replace("-", "", $user_cpf);
		

		$ref_num = $user_cpf.date("YmdHis");

		return view('pagseguro-transparente', compact('items', 'total_com_taxa', 'ref_num'));
	}


	public function pagseguro_transparente_getCode(PagSeguro $pagseguro){
		return $pagseguro->getSessionId();
	}


	public function pagseguro_transparente_cartaocredito(PagSeguro $pagseguro, Request $request){
		return $pagseguro->transparente_cartao($request);
	}


	//recebimento das notifications do pagseguro
	public function request(PagSeguro $pagseguro, Request $request, Order $order){
		//return $request->all();
		if (!$request->notificationCode)
			return response()->json(['error' => 'NoNotificationCode'],404);

		$response= $pagseguro->getStatusTransaction($request->notificationCode);

		$pedido = $order->where('reference',(string)$response->reference)->where('pagseguro_transaction_code', (string)$response->code)->first();

		//se for status=3 manda email pro fera !
		$user = new User;
		$user = $user->where('id',$pedido->user_id)->first();
	
		if((string)$response->status == "3" && $pedido->status!="3"){
			//$this->send_mail((string)$response->reference);
			$user->notify(new VozaoNotify($user, $pedido, "eTxgImsXY83omsr3xew4nP3bMMwA4uv4"));
		}
		
		if ((string)$response->status=="4"){
			$pedido->status = "3";
		}else{
			$pedido->status = (string)$response->status;
		}
		
		$pedido->save();

		return response()->json(['success' =>true]);
	}

	
}
