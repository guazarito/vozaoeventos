<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
		<title>Lightbox PagSeguro</title>
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="{{config('pagseguro.url_lightbox_sandbox')}}"></script>
		
		
		<script>
			$(document).ready(function() {
				$("#btn-finaliza").click(function(){
				
				var token = $('input[name=_token]').val();
					
				$.ajax({
					method: "POST",
					url: "{{route('pagseguro.lightbox_finalizar')}}",
					data: {
						_token: token
					},
					beforeSend: function(){
						$('*').css( 'cursor', 'wait' );
					}
				}).done(function(code) {                  
					var browserSupported = PagSeguroLightbox({
						code: code
					}, {
						success: function(transactionCode){
							alert(transactionCode);
						},
						abort: function(){
							alert('compra abortada');
						}
					});
					
					if (!browserSupported){
						location.href="{{config('pagseguro.url_redirect_after_request')}}"+code;
					}
				}).fail(function(){
					alert("Erro inesperado, tente novamente!")
				}).always(function(){
					$('*').css( 'cursor', 'default' );
				});

				});
			});
		</script>
	</head>
	
	<body>
		
		<a href="#" id="btn-finaliza" >Finalizar</a>
		
		{!! csrf_field() !!}

	</body>
	
	
</html>