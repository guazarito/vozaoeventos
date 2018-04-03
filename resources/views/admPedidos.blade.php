@extends('layout')

@section('content')


<div class="container meus_pedidos">
	<h1 id="meuspedidos_title">Pedidos</h1>
	<br>
@if (sizeof($pedidos)>0)
<!--	
	<p>Quantidade total de pedidos: <b style="color: #8D0101;">{{sizeof($pedidos)}}</b></p>
	<p>Quantidade total de ingressos: <b style="color: #8D0101;">{{$somaTotalingressos}}</b></p>
	<!--<p>Valor todos Pedidos: <b style="color: #8D0101;">R$ {{number_format($somaTotalPedidos,2)}}</b></p>
	<br>
	<p>Quantidade de pedidos pagos: <b style="color: #8D0101;">{{sizeof($pedidos->where('status','3'))}}</b></p>
	<p>Quantidade de ingressos pagos: <b style="color: #8D0101;">{{$somaTotalingressosPagos}}</b></p>
	<p>Valor Pedidos Pagos: <b style="color: #8D0101;">R$ {{number_format($somaTotalPedidosPagos,2)}}</b></p>
	<br>
	<p>Quantidade de pedidos pendentes: <b style="color: #8D0101;">{{sizeof($pedidos->where('status','<>','3')->where('status','<>','7')->where('status','<>','4'))}}</b></p>
	<p>Quantidade de ingressos pendentes: <b style="color: #8D0101;">{{$somaTotalingressosPendentes}}</b></p>
	<p>Valor Pedidos Pendentes: <b style="color: #8D0101;">R$ {{number_format($somaTotalPedidosPendentes,2)}}</b></p>
	<br>
	<p>Quantidade de pedidos cancelados: <b style="color: #8D0101;">{{sizeof($pedidos->where('status','7'))}}</b></p>
	<br>
-->
	<?php $i=0; ?>
	<table class="table" style="border-bottom:2px solid #dddddd;">
	  <thead>
	    <tr>
	      <th>ID</th>
	      <th>Usuário</th>
	      <th>Descrição</th>
	      <th>Qtde</th>
	      <th>Data</th>
	      <th>Ref. Code</th>
	      <th>Cod. PagSeguro</th>
	      <th>Status</th>
	      <th>Valor Total</th>
	    </tr>
	  </thead>
	  <tbody>
	  	@foreach($pedidos as $order)

	  	<?php $i++; 
		$status_nome ="";

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
	      <th scope="row">{{$order->id}}</th>
	      <td>{{$order->getUserName($order->user_id)->name}}</td>
	      <td><h3 style="display: inline;">Natal Vozão 2017</h3><p>Ingresso (lote {{$order->lote}}) / Unisex</p></td>
	      <td>x{{$order->qtde}}</td>
	      <td>{{date_format($order->created_at,"d/m/Y")}}</td>
	      <td>{{$order->ref_number_md5}}</td>
	      <td>{{str_replace("-","",$order->pagseguro_transaction_code)}}</td>
	      <td id="status_nome">{{$status_nome}}</td>
	      <td>R$ {{str_replace(".",",",number_format($order->preco_total,2))}}</td>
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


@endsection