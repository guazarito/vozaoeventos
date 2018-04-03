<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\User;

class apiController extends Controller
{    
    public function check_qr_code(){
		  if (isset($_SERVER['HTTP_ORIGIN'])) {
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
    }
 
    // Access-Control headers are received during OPTIONS requests
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
 
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         
 
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers:        {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
 
        exit(0);
    }
	 
    	$pedidos = new Order;
		$user = new User;
	
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata);
		//dd($request->qr_md5);
		
    	$pedido = $pedidos->join('users','user_id','=','users.id')->where('ref_number_md5', $request->qr_md5)->first();
		//$user = $user->where('id', $pedido->user_id)->first();
			
    	if ($pedido === null){
    		return response()->json(['erro' =>$request->qr_md5], 404);
    	}else{
			echo $pedido->toJson();
			//return response()->json(['success' =>true]);
    	}
    }
	
	public function retirar_ingressos(){
		  if (isset($_SERVER['HTTP_ORIGIN'])) {
			header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
			header('Access-Control-Allow-Credentials: true');
			header('Access-Control-Max-Age: 86400');    // cache for 1 day
		}
	 
		// Access-Control headers are received during OPTIONS requests
		if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
	 
			if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
				header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         
	 
			if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
				header("Access-Control-Allow-Headers:        {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
	 
			exit(0);
		}
		
		$pedidos = new Order;
	
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata);
		//dd($request->qr_md5);
		
    	$pedido = $pedidos->where('ref_number_md5', $request->qr_md5)->first();
		
		if ($pedido === null){
    		return response()->json(['erro' =>$request->qr_md5], 404);
    	}else{
			//atualiza
			if ($pedido->retirado == 1){
				return response()->json(['erro' =>"ingressos ja retirados!!! ".$request->qr_md5], 404);
			}else{
				$pedido->retirado =1;
				$pedido->save();
				return response()->json(['success' =>true]);
			}
			//return response()->json(['success' =>true]);
    	}
	}
	
	public function lista_ingressos(){
		  if (isset($_SERVER['HTTP_ORIGIN'])) {
			header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
			header('Access-Control-Allow-Credentials: true');
			header('Access-Control-Max-Age: 86400');    // cache for 1 day
		}
	 
		// Access-Control headers are received during OPTIONS requests
		if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
	 
			if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
				header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         
	 
			if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
				header("Access-Control-Allow-Headers:        {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
	 
			exit(0);
		}
		
		$pedidos = new Order;
	
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata);
		//dd($request->tipo_ingresso);
		
		$tipo_ingresso = $request->tipo_ingresso;
		
		if($tipo_ingresso == "retirados"){
			echo $pedidos->join('users','user_id','=','users.id')->where('retirado', "1")->where('status','3')->orwhere('status','4')->orderby('orders.created_at','desc')->get()->toJson();
		}else if($tipo_ingresso == "nao_retirados"){
			echo $pedidos->join('users','user_id','=','users.id')->where('retirado', "0")->where('status','3')->orwhere('status','4')->orderby('orders.created_at','desc')->get()->toJson();
		}else{
			echo $pedidos->join('users','user_id','=','users.id')->orderby('orders.created_at','desc')->get()->toJson();
		}
	}
}
