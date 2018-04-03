<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'stripe/*',
		"/adm/edita_preco_inline/*",
		"/teste_pagseguro/*",
		"/comprar",
		"/logout",
		"/edita_meusdados_inline/*",
       // "/checkout/*"
		
		//"/checkout/finalizar_checkout/aAl7yeussXpDGYOYemONtXGDPdcMEc5A1LRwYJ9pFCWMPcH80u"
    ];
}
