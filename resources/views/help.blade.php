
@extends('layout')

@section('content')

		<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>

		<script>
			$(document).ready(function() {
				$("#help_form").validate({
						errorClass:'validationClass',
						rules: {
						    nome: {
						      required: true,
						    },
						    email:{
						      required: true,
						    },
						    tel:{
						      required: true,
						    },
						    msg:{
						    	required: true
						    },
						 },
						 messages:{					 	
					 		nome: "Campo obrigatório",
					 		email: "Campo obrigatório",
					 		tel: "Campo obrigatório",
					 		msg: "Campo obrigatório"
					  	},
						  submitHandler: function(form) {

						  	$('.msg').css('display','block');
						  	$('#help_form').submit();
						  	
	  					  }
						});
			});
		</script>

		<div class="container">

			<div class="row">
				<div class="col-sm-12 col-md-12">
				<h1 id="help_title">Ajuda</h1>
				<h3 id="contato_txt">Qualquer dúvida ou problema, estamos aqui para ajudar! Envie-nos uma mensagem que entraremos em contato o mais breve possível</h3>
				<form id="help_form" method="POST" action="{{route('contato')}}">
					{!! csrf_field() !!}
				  <div class="form-group">
				    <label for="lbl_name">Nome:</label>
				    <input type="text" class="form-control" name="nome">
				  </div>
				  <div class="form-group">
				    <label for="lbl_email">Email:</label>
				    <input type="email" class="form-control" name="email">
				  </div>
				  <div class="form-group">
				    <label for="lbl_tel">Telefone:</label>
				    <input type="tel" class="form-control" name="tel">
				  </div>				  
				  <div class="form-group">
				    <label for="lbl_msg">Mensagem:</label>
				    <textarea rows="4" class="form-control" name="msg"></textarea>
				  </div>

				  <button type="submit" class="btn btn-default">Enviar</button>
				  <div class="msg alert alert-success" style="display: none;">Email enviado com sucesso. Entraremos em contato o mais breve possível.</div>
				</form>
			</div>
		</div><!--container-->

@endsection