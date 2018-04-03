@extends('layout')

@section('content')

@section('num_carrinho')
	 <li><a href="{{route('ver_carrinho')}}"><span class="glyphicon glyphicon-shopping-cart"></span> Carrinho ({{$num_carrinho}})</a></li>
@endsection


<div class="container meus_pedidos">
	<h1 id="meuspedidos_title">Meus Pedidos</h1>
	<br>
@if (sizeof($orders)>0)
	<?php $i=0; ?>
	<table class="table" style="border-bottom:2px solid #dddddd;">
	  <thead>
	    <tr>
	      <th>#</th>
	      <th>Descrição</th>
	      <th>Qtde</th>
	      <th>Total</th>
	      <th>Data</th>
	      <th>Status</th>
	      <th></th>
	    </tr>
	  </thead>
	  <tbody>
	  	@foreach($orders as $order)
	  	<?php $i++; 

		switch ($order->status) {
	    case 1:
	        $status_nome = "Aguardando pagamento";
	        break;
	    case 2:
	        $status_nome = "Em análise";
	        break;
	    case 3:
	        $status_nome = "Pago";
	        break;
	    case 4:
	        $status_nome = "Disponível";
	        break;
	    case 5:
	        $status_nome = "Em disputa";
	        break;
	    case 6:
	        $status_nome = "Devolvida";
	        break;
	    case 7:
	        $status_nome = "Cancelada";
	        break;
	    case 8:
	        $status_nome = "Debitado";
	        break;
	    case 9:
	        $status_nome = "Retenção temporária";
	        break;
	    }

	  	?>
	    <tr>
	      <th scope="row">{{$i}}</th>
	      <td><h3 style="display: inline;">Natal Vozão 2017</h3><p>Ingresso (lote {{$order->lote}}) / Unisex</p></td>
	      <td>x{{$order->qtde}}</td>
	      <td>R$ {{str_replace(",",".",number_format($order->preco_total,2))}}</td>
	      <td>{{date_format($order->created_at,"d/m/Y")}}</td>
	      <td id="status_nome">{{$status_nome}}</td>
	      <td>
	      	@if($order->status==3 or $order->status==4)
	      		<form id="frmVoucher" method="POST" action="{{route('baixavoucher')}}">
	      			<button class="btn btn-success" type="submit"><spam class="glyphicon glyphicon-save"></spam> Baixar Voucher</button>
	      			<input type="hidden" name="ref_number" value="{{md5($order->reference)}}">
	      			{!! csrf_field() !!}
	      		</form>
	      	@endif
	      </td>
	    </tr>
	    @endforeach
	  </tbody>
	</table>

@else
<p>Nenhum pedido encontrado.</p>
<style>
  #footer{
  position: absolute;
  bottom: 0;
  }
</style>
@endif
</div><!--container-->

@if (sizeof($orders)==1)
<style>
 #footer{
  position: absolute;
  bottom: 0;
  }
</style>
@endif


@endsection