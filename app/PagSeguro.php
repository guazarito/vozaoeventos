<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use GuzzleHttp\Client as Guzzle;
use Auth;

class PagSeguro extends Model
{
  

	public function getSessionId(){

		$params = [
		'email'=>config('pagseguro.email'),
		'token'=>config('pagseguro.token')
		];

		$guzzle = new Guzzle;
		$response = $guzzle->request("POST", config('pagseguro.url_sessaopagto'), [
			'form_params' => $params,  'verify' => false, 'header'=>'<meta name="csrf-token" content="{{ csrf_token() }}">', 'allowedHeaders' => ['Origin', 'X-Requested-With', 'Content-Type', 'Accept']
		]);
		
		$body = $response->getBody();
		$contents = $body->getContents();
		
		$xml = simplexml_load_string($contents);	

		return($xml->id);	
	}

	

	public function transparente_cartao($request){

		$numcel= Auth::user()->celular;
		$numcel= str_replace("(", "", "$numcel");
		$numcel= str_replace(")", "", "$numcel");
		$numcel= str_replace("-", "", "$numcel");
		$numcel= str_replace(" ", "", "$numcel");

		$ddd= substr($numcel, 0,2);
		$phone= substr($numcel,2);

		$user_cpf = Auth::user()->cpf;
		$user_cpf = str_replace(".", "", $user_cpf);
		$user_cpf = str_replace("-", "", $user_cpf);

		$holder_cpf = $request->holder_cpf;
		$holder_cpf = str_replace(".", "", $holder_cpf);
		$holder_cpf = str_replace("-", "", $holder_cpf);	

		if (env('PAGSEGURO_ENV')=="prd"){
			$user_email = Auth::user()->email;
		}else{
			$user_email = "c10247802559140413499@sandbox.pagseguro.com.br";
		}

		$total_sem_taxa = $request->preco_total_com_taxa / 1.1;
				
		$valor_item = $total_sem_taxa/(int)$request->qtde;
		$valor_item = number_format($valor_item,2);

		$total_sem_taxa = number_format($total_sem_taxa, 2);

		$taxa = number_format($total_sem_taxa*(float)config('pagseguro.taxa'),2);

		$name = preg_replace('/\d/', '', Auth::user()->name);

		
		$name = preg_replace('/[\n\t\r]/', ' ', $name);
		$name = preg_replace('/\s(?=\s)/', '', $name);
		$name = trim($name);
		$name = explode(' ', $name);
		 
		if(count($name) == 1 ) {
		    $name[] = 'da Silva';
		}
		$name = implode(' ', $name);

		$params = [
		    'email' => config('pagseguro.email'),
		    'token' => config('pagseguro.token'),
		    'senderHash' => $request->senderHash,
		    'paymentMode' => 'default',
		    'paymentMethod' => 'creditCard',
		    'currency' => 'BRL',
		    'itemId1' => '0001',
		    'itemDescription1' => 'Ingresso Natal Vozao 2017',
		    'itemAmount1' => $valor_item,
		    'extraAmount'=>$taxa,
		    'itemQuantity1' => $request->qtde,
		    'reference' => $request->ref_number,
		    'senderName' => $name,
		    'senderAreaCode' => $ddd,
		    'senderPhone' => $phone,
		    'senderEmail' => $user_email,//'c46917360443542888496@sandbox.pagseguro.com.br',
		    'senderCPF' => $user_cpf,
		    'shippingType' => '3',
		    'creditCardToken'=>$request->cardToken,
		    'creditCardHolderName'=>strtoupper($request->holder_name),
		    'creditCardHolderCPF'=>$holder_cpf,
		    'creditCardHolderBirthDate'=>$request->holder_dtnasc,
			'creditCardHolderAreaCode'=> $ddd,
			'creditCardHolderPhone'=> $phone,
		    'shippingAddressStreet'=>'Av. PagSeguro',
			'shippingAddressNumber'=>'9999',
			'shippingAddressComplement'=>'99o andar',
			'shippingAddressDistrict'=>'Jardim Internet',
			'shippingAddressPostalCode'=>'99999999',
			'shippingAddressCity'=>'Cidade Exemplo',
			'shippingAddressState'=>'SP',
			'shippingAddressCountry'=>'ATA',
			'billingAddressStreet'=>'Av. PagSeguro',
			'billingAddressNumber'=>'9999',
			'billingAddressComplement'=>'99o andar',
			'billingAddressDistrict'=>'Jardim Internet',
			'billingAddressPostalCode'=>'99999999',
			'billingAddressCity'=>'Cidade Exemplo',
			'billingAddressState'=>'SP',
			'billingAddressCountry'=>'ATA',
			'installmentQuantity'=>'1',
			'installmentValue'=>$request->preco_total_com_taxa
		];
		
		//dd($params);
		//$params = http_build_query($params);
		
		$guzzle = new Guzzle;
		$response = $guzzle->request("POST", config('pagseguro.url_payment_transparente'), [
			'form_params' => $params,  'verify' => false, 'header'=>'<meta name="csrf-token" content="{{ csrf_token() }}">', 'allowedHeaders' => ['Origin', 'X-Requested-With', 'Content-Type', 'Accept']
		]);
		
		$body = $response->getBody();
		$contents = $body->getContents();
		
		$xml = simplexml_load_string($contents);

		
		return($xml->code);

	}

	public function getStatusTransaction($notificationCode){
		$guzzle = new Guzzle;

		$response = $guzzle->request("GET", config('pagseguro.url_notification')."/$notificationCode", [
			'query' => "email=".config('pagseguro.email')."&token=".config('pagseguro.token') 
		]);

		$body = $response->getBody();
		$contents = $body->getContents();
		
		$xml = simplexml_load_string($contents);

		return $xml;
	}
}
