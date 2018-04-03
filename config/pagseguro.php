<?php


if (env('PAGSEGURO_ENV')=='sandbox'){
	return [
		
		'environment' => env('PAGSEGURO_ENV'),
		'email' => env('PAGSEGURO_EMAIL'),
		'token' => env('PAGSEGURO_TOKEN'),


		'url_checkout' => 'https://ws.sandbox.pagseguro.uol.com.br/v2/checkout',

		'url_redirect_after_request' => 'https://sandbox.pagseguro.uol.com.br/v2/checkout/payment.html?code=',

		'url_sessaopagto' => 'https://ws.sandbox.pagseguro.uol.com.br/v2/sessions',

		'url_transparente_js' => 'https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js',

		'url_payment_transparente' => 'https://ws.sandbox.pagseguro.uol.com.br/v2/transactions',

		'url_notification' => 'https://ws.sandbox.pagseguro.uol.com.br/v3/transactions/notifications',

		'taxa' => '0.1'
	];
}elseif (env('PAGSEGURO_ENV')=='prd') {
	return [
		
		'environment' => env('PAGSEGURO_ENV'),
		'email' => env('PAGSEGURO_EMAIL'),
		'token' => env('PAGSEGURO_TOKEN'),

		'url_checkout' => 'https://ws.pagseguro.uol.com.br/v2/checkout',

		'url_redirect_after_request' => 'https://sandbox.pagseguro.uol.com.br/v2/checkout/payment.html?code=',

		'url_sessaopagto' => 'https://ws.pagseguro.uol.com.br/v2/sessions',

		'url_transparente_js' => 'https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js',

		'url_payment_transparente' => 'https://ws.pagseguro.uol.com.br/v2/transactions',

		'url_notification' => 'https://ws.pagseguro.uol.com.br/v3/transactions/notifications',

		'taxa' => '0.1'
	];
}




?>