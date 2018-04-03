@extends('layout')

@section('content')

		<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
		<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
		<script src="{{asset('layout/js/jquery.mask.min.js')}}"></script>

		<script src="{{config('pagseguro.url_transparente_js')}}"></script>

		<script>	
			$(document).ready(function() {

				$("#loader").css('position','absolute');
				$("#loader").css('top', ($(window).height()/2) );			
				$("#loader").css('left', ($(window).width()/2) );

				    
           if($(window).height()>780){
                $("#footer").css('position', 'absolute');
                $("#footer").css('bottom', '0');
            }
   
			

				setSessionId();
				
				

				$('#dt_nasc').mask('00/00/0000');
				$("#cpf").mask('000.000.000-00');


				jQuery.validator.addMethod("cpf", function(value, element) {
				   value = jQuery.trim(value);

				    value = value.replace('.','');
				    value = value.replace('.','');
				    cpf = value.replace('-','');
				    while(cpf.length < 11) cpf = "0"+ cpf;
				    var expReg = /^0+$|^1+$|^2+$|^3+$|^4+$|^5+$|^6+$|^7+$|^8+$|^9+$/;
				    var a = [];
				    var b = new Number;
				    var c = 11;
				    for (i=0; i<11; i++){
				        a[i] = cpf.charAt(i);
				        if (i < 9) b += (a[i] * --c);
				    }
				    if ((x = b % 11) < 2) { a[9] = 0 } else { a[9] = 11-x }
				    b = 0;
				    c = 11;
				    for (y=0; y<10; y++) b += (a[y] * c--);
				    if ((x = b % 11) < 2) { a[10] = 0; } else { a[10] = 11-x; }

				    var retorno = true;
				    if ((cpf.charAt(9) != a[9]) || (cpf.charAt(10) != a[10]) || cpf.match(expReg)) retorno = false;

				    return this.optional(element) || retorno;

				}, "Informe um CPF válido");

				$("#paymentForm").validate({
					errorClass:'validationClass',
					rules: {
					    cardNumber: {
					      required: true,
					      creditcard: true
					    },
					    holder_dtnasc:{
					      required: true
					    },
					    cvv:{
					      required: true,
					      digits: true
					    },
					    holder_name:{
					    	required: true
					    },
					    holder_cpf:{
					    	cpf: true,
					    	required: true
					    }
					 },
					 messages:{					 	
					 		cardNumber: "Por favor, informe um cartão de crédito válido.",
					 		holder_dtnasc: "Por favor, informe uma data válida.",
					 		cvv: "Somente números permitido",
					 		holder_name:{required: "Campo obrigatório"},
					 		holder_cpf:{required: "Campo obrigatório"}
					  },
					  submitHandler: function(form) {
					  		$("#loader").css('display','block');
					  		$("#loading").css('display','block');
					  		$("#btnCheckoutCard").prop('disabled', true);
    							getBrandCard();
							
  					  }
					});

			});


			//cartao:
			function CardTransaction(){
				var senderHash = PagSeguroDirectPayment.getSenderHash();
				var dadosForm = $("#paymentForm").serialize()+"&senderHash="+senderHash;
						
				$.ajax({
					method: "POST",
					url: "/pagseguro/transparente/cartao-credito", 
					data: dadosForm,
					beforeSend: function(){
						$('*').css( 'cursor', 'wait' );
					}
				}).done(function(code) {                  
								$.ajax({
										method: "POST",
										url: "{{route('finalizar_checkout')}}",
										data: dadosForm+"&transactionCode="+code,
										beforeSend: function(){
											$('*').css( 'cursor', 'wait' );
										}
									}).done(function(code) {
										//$("#loading").css('display','none');
										//$("#loader").css('display','none');
					  					$("#btnCheckoutCard").prop('disabled', false);
										window.location = "{{route('congrats')}}";								
									}).fail(function(){
										alert("Erro ou pedido inválido. Tente novamente ou peça ajuda pelo menu AJUDA!");
									}).always(function(){
										$('*').css( 'cursor', 'default' );
										$("#loading").css('display','none');
										$("#loader").css('display','none');
					  					$("#btnCheckoutCard").prop('disabled', false);
									});	 
				}).fail(function(){
					alert("Erro inesperado na transação, por favor, verifique os dados do cartão e tente novamente!");
				}).always(function(){
					$('*').css( 'cursor', 'default' );
					$("#loading").css('display','none');
					$("#loader").css('display','none');
					$("#btnCheckoutCard").prop('disabled', false);
				});	 		
			}

			

			function createCardToken(){
				PagSeguroDirectPayment.createCardToken({
				    cardNumber: $('input[name=cardNumber]').val().replace(/ /g,''),
				    brand: $('input[name=bandeira]').val(),
				    cvv: $('input[name=cvv]').val().replace(/ /g,''),
				    expirationMonth: $('#month').find(":selected").val(),
				    expirationYear: $('#year').find(":selected").val(),
				    success: function(response){
				    	$('input[name=cardToken]').val(response.card.token);
				    	CardTransaction();
				    } ,
				    error: function(response){
						alert('erro inesperado no processamento do token do cartão de crédito.\n Tente novamente, por favor.');
				    } ,
				    complete: function(){
				    	
				    }
				});
			}

			function getBrandCard(){
			
				PagSeguroDirectPayment.getBrand({
					cardBin: $('input[name=cardNumber]').val().replace(/ /g,''),
					success: function(response){
						$('input[name=bandeira]').val(response.brand.name);
						createCardToken();
					},
					error: function(response){
						alert('erro dados do cartão');
					},
					complete: function(response){
						
					}
				});
			}
			//fim cartao

			function setSessionId(){
				var token = $('input[name=_token]').val();
				$.ajax({
					method: "POST",
					url: "/pagseguro/transparente", 
					data: {
						_token: token
					},
					beforeSend: function(){
						$('*').css( 'cursor', 'wait' );
					}
				}).done(function(data) {                  
					PagSeguroDirectPayment.setSessionId(data);
					$("#loading").css('display','none');
					$("#loader").css('display','none');
					$("#btnCheckoutCard").prop('disabled', false);
				}).fail(function(){
					alert("Erro inesperado, tente novamente!")
				}).always(function(){
					$('*').css( 'cursor', 'default' );
				});
			}

		</script>


		<div class="container">
		<h1 id="checkout_title">Finalizar Compra</h1>
		<br>
		<div id="cartao_credito">
				<ul class="nav nav-tabs">
					<li class="active"><i class="glyphicon glyphicon-credit-card"></i> Cartão de Crédito</a></li>
				</ul>
				<div class="tab-content" style="margin-top:20px;">
				<div id="credit" class="tab-pane fade in active">
				<form class="form" method="post" id="paymentForm">
					{!! csrf_field() !!}
				<div class="form-group">
				<label for="card">Número do cartão: </label>
				<div class="credit-card">
				<input type="tel" name="cardNumber" id="card" class="form-control" placeholder="Ex: 0000 0000 0000 0000">
				<input type="hidden" name="bandeira">
				<input type="hidden" name="cardToken">
				</div>
				</div>
				<div class="row">
				<div class="col-md-2 col-xs-6">
				<div class="form-group">
				<label for="month">Mês: </label>
				<select id="month" name="month" class="form-control">
				<option value="1">
				1
				</option>
				<option value="2">
				2
				</option>
				<option value="3">
				3
				</option>
				<option value="4">
				4
				</option>
				<option value="5">
				5
				</option>
				<option value="6">
				6
				</option>
				<option value="7">
				7
				</option>
				<option value="8">
				8
				</option>
				<option value="9">
				9
				</option>
				<option value="10">
				10
				</option>
				<option value="11">
				11
				</option>
				<option value="12">
				12
				</option>
				</select>
				</div>
				</div>
				<div class="col-md-3 col-xs-6">
				<div class="form-group">
				<label for="year">Ano: </label>
				<select id="year" name="year" class="form-control">
				<option value="2017">
				2017
				</option>
				<option value="2018">
				2018
				</option>
				<option value="2019">
				2019
				</option>
				<option value="2020">
				2020
				</option>
				<option value="2021">
				2021
				</option>
				<option value="2022">
				2022
				</option>
				<option value="2023">
				2023
				</option>
				<option value="2024">
				2024
				</option>
				<option value="2025">
				2025
				</option>
				<option value="2026">
				2026
				</option>
				<option value="2027">
				2027
				</option>
				<option value="2028">
				2028
				</option>
				<option value="2029">
				 2029
				</option>
				<option value="2030">
				2030
				</option>
				<option value="2031">
				2031
				</option>
				<option value="2032">
				2032
				</option>
				<option value="2033">
				2033
				</option>
				<option value="2034">
				2034
				</option>
				<option value="2035">
				2035
				</option>
				<option value="2036">
				2036
				</option>
				<option value="2037">
				2037
				</option>
				<option value="2038">
				2038
				</option>
				<option value="2039">
				2039
				</option>
				<option value="2040">
				2040
				</option>
				</select>
				</div>
				</div>
				<div class="col-md-7 col-xs-12">
				<div class="form-group">
				<label for="ccv">Cód. Segurança: </label>
				<input type="tel" name="cvv" id="cvv" class="form-control" placeholder="Ex: 998">
				</div>
				</div>
				</div>
				<div class="form-group">
				<label for="name">Nome do titular: </label>
				<input type="text" name="holder_name" id="name" class="form-control" placeholder="Igual impresso no cartão">
				</div>
				<div class="row">
				<div class="col-md-6 col-xs-12">
				<div class="form-group">
				<label for="cpf">CPF do titular: </label>
				<input type="tel" name="holder_cpf" id="cpf" class="form-control" placeholder="Ex: 000.000.000-99">
				</div>
				</div>
				<div class="col-md-6 col-xs-12">
				<div class="form-group">
				<label for="cpf">Data nascimento titular: </label>
				<input type="tel" name="holder_dtnasc" id="dt_nasc" class="form-control" placeholder="Ex: 01/01/1994">
				</div>
				</div>
				</div>
				
				<div class="col-md-12 text-right">
				<p style="color:#8F8F8F; font-size:14px;">Pagamento processado por <img src="/layout/img/pagseguro.png" class="img-responsive" style="width:120px; height:25px; display:inline-block"></p>
				</div>

				<button type="submit" id="btnCheckoutCard" disabled class="btn btn-success" style="width:100%; text-align:center;">Realizar pagamento</button>
			
				<div id="loading">
					<p>Processando... Aguarde!</p>
				</div>

				@if (sizeof($items)>0)
				<input type="hidden" name="qtde" value="{{$items['qtde']}}">
				<input type="hidden" name="lote" value="{{$items['lote']}}">
				<input type="hidden" name="preco_total_com_taxa" value="{{$total_com_taxa}}">
				<input type="hidden" name="ref_number" value="{{$ref_num}}">
				@endif

				</form>
		</div><!-- cartao credito -->
	</div><!--container-->
			<div id="loader">
			
		</div>

</div>
@endsection