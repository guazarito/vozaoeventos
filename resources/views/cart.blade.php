@extends('layout')

@section('content')

<script>
    $(document).ready(function() {
           if($(window).height()>780){
                $("#footer").css('position', 'absolute');
                $("#footer").css('bottom', '0');
            }
    });
			


</script>


<div class="container" id="cart_container">
  <div class="col-md-12 col-xs-12">
	<h1  id="cart_title">Carrinho de compras</h1>

@if (sizeof($items)>0)
<br>
<table class="table" id="cart_tbl">
  <thead>
    <tr>
      <th>#</th>
      <th>Evento</th>
      <th>Qtd</th>
      <th>Preço unitário</th>
      <th>Preço Total</th>
      <th style="text-align: center;">Remover</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">1</th>
      <td><h3 style="display: inline;">Natal Vozão 2017</h3><p>Ingresso (lote {{$items['lote']}}) / Unisex</p></td>
      <td>x{{$items['qtde']}}</td>
      <td>R$ {{$items['preco_unidade']}}</td>
      <td>R$ {{$total_carrinho}}</td>
      <td style="text-align: center;"><a id="remover" href="{{route('remover_carrinho')}}"><i style="color: #999999;" class="glyphicon glyphicon-remove"></i></a></td>
    </tr>
  </tbody>
</table>

<div class="row" >
	<div class="col-sm-4 col-sm-push-8" >
		<p>Taxa de conveniência: <strong>R$ {{$taxa}}</strong></p>
		<p>Total: <strong>R$ {{$total_com_taxa}}</strong></p>
	</div>
</div>
<div class="row" >
	<div class="col-sm-2 col-sm-push-10" style="margin-top: 20px;" >
		<a href="{{route('pagseguro.transparente')}}" class="btn btn-warning">Finalizar Compra</a>
	</div>
</div>
@else
<p>Nenhum item no carrinho</p>
<style>
  #footer{
  position: absolute;
  bottom: 0;
  }
</style>
@endif
</div>
</div><!--container-->




@endsection