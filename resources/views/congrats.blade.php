
@extends('layout')

@section('content')


		<div class="container">
			<div class="row congrats">
				<h1>Parabéns!</h1>
				<h3>Vc adquiriu o ingresso do melhor Natal de Araraquara e região.</h3><br>
				<b><p>Assim que seu pagamento for confirmado <u>(prazo máximo do PagSeguro é de 10 horas)</u>, vc receberá em seu email um Voucher para entrada no evento.</p></b>
				<p>Vc poderá, também, baixar o Voucher na área <u><a href="{{route('meuspedidos')}}">Meus Pedidos</a></u>, quando o pagamento estiver confirmado.</p>
				<p>Imprima ou apresente este Voucher na tela de seu celular, <u><b>acompanhado de documento original com foto!</b></u>
				</p><br>
				<p><b>ATENÇÃO:</b> A não apresentação de documento de identificação original com foto acarretará em cancelamento do Voucher.</p>
			</div>
		</div><!--container-->
<style>
 #footer{
  position: absolute;
  bottom: 0;
  }
</style>
@endsection