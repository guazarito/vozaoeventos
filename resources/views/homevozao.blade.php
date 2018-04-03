@extends('layout')


@section('num_carrinho')
	 <li><a href="{{route('ver_carrinho')}}"><span class="glyphicon glyphicon-shopping-cart"></span> Carrinho ({{$num_carrinho}})</a></li>
@endsection




@section('content')
		
		<div class="container">
			<div class="row" id="evento_info">
				<div class="col-sm-6 col-md-7" id="evento_header">
					<h1>Natal Vozão 2017</h1>
					<h3>Chácara Alvorada - Araraquara/SP</h3>
				</div>
				<div class="col-sm-6 col-md-5" id="data_evento_header">
					<h1>25/12/2017</h1>
					<h3>1:00 às 8:00 - Open Bar</h3>
				</div>
			</div>
			<div class="row" id="evento_lineup">
				<div class="col-sm-6 col-md-7">
					<div class="col-sm-6 col-md-12">
						<img style="width: 100%" src="{{asset('layout/img/banner_vozao2017.jpg')}}">
					</div>
					<div class="col-sm-6 col-md-12" id="evento_fb">
						Confirme sua presença: <a href="https://www.facebook.com/events/136579890324570" target="_blank" class="btn btn-primary">Evento do Facebook</a>
					</div>
					<div class="" id="atracoes">
						<h2>ATRAÇÕES</h2>
						<ul>
							<li><h3>CIDADE VERDE SOUNDS</h3></li>
							<li><h3>EKENA</h3></li>
							<li><h3>DJ KUURTZ</h3></li>
						</ul>
					</div>
					<div class="" id="ponto_venda">
						<h2>Pontos de Venda</h2>
						<ul>
							<li><h3><a href="https://www.facebook.com/pages/Old-Class-Custom-Tattoo/227902601047661" target="_blank">Old Class Custom Tattoo</a></h3></li>
							<li><p><b>Endereço:</b> Av. 15 de novembro, 603, esquina com a rua 5 - Araraquara/SP</p></li>
							<li><p><b>Telefone:</b> (16) 99743-2240</p></li>
							<li><p>Dinheiro e CARTÃO (Débito e Crédito à vista)</p></li>
						</ul>
						<ul>
							<li><h3><a href="https://www.facebook.com/fratellowaffle/" target="_blank">Fratello Waffles</a></h3></li>
							<li><p><b>Endereço:</b> Av. 7 de setembro, 823 - Araraquara/SP</p></li>
							<li><p><b>Telefone:</b> (16) 3010-1300</p></li>
						</ul>
					</div>					
					<div class="" id="obs">
						<h2>OBS</h2>
						<ul>
							<li>
								<p>É proibida a entrada de menores de 18 anos;</p>
							</li>
							<li>
								<p>É indispensável a apresentação de um documento com foto (RG/CNH);</p>
							</li>
							<li>
								<p>Não será tolerada nenhuma atitude racista, machista, homofóbica ou que ofereça qualquer dano à integridade moral, ou física, de qualquer indivíduo. Sob pena de expulsão do evento;</p>
							</li>
						</ul>
					</div>
				</div><!--col-->
				<div class="col-sm-6 col-md-5">
					<div id="ingresso">Compre seu ingresso</div>
					<div class="msg alert alert-warning" style="display: none;">Selecione a quantidade.</div>
					<form id="vozao2017" class="form" method="post" action="{{route('comprar')}}">
					 {{ csrf_field() }}

					 @if( sizeof($preco_atual)>0)
						 <div class="form-group">
						 	
						<table class="table">
							  <thead>
							    <tr>
							      <th>Evento</th>
							      <th>Preço</th>
							      <th>Quantidade</th>
							    </tr>
							  </thead>
							  <tbody>
							    <tr>
							      <td>Natal Vozão 2017<p id="lote_info">(Lote {{$preco_atual->lote}})</p></td>
							      <td><strong>R$ <span id="preco-ingresso">{{str_replace(".",",",number_format($preco_atual->preco,2))}}</span></strong></td>
							      <td>
							      	<select id="qtde-ingresso" name="qtde_ingressos" class="form-control">
										<option value="0">0</option>
										<option value="1">1</option>
										<option value="2">2</option>
										<option value="3">3</option>
										<option value="4">4</option>
										<option value="5">5</option>
										<option value="6">6</option>
										<option value="7">7</option>
										<option value="8">8</option>
										<option value="9">9</option>
										<option value="10">10</option>
									</select>
								</td>
							    </tr>

							    <tr>
							      <td>Total: <strong style="color: #8D0101;">R$ <input type="text" readonly id="preco-total" name="total" value="0,00"></input></strong></td>
							     							      <td colspan="2"><button type="button" id="comprar-botao"  class="btn btn-warning">COMPRAR</button></td>
								  					<!--<div class="msg alert alert-success"  style="display: block;">Vendas encerradas</div>-->
							    </tr>
							  </tbody>
						</table>			
							
							
					@endif
						  
				    </form>
				</div><!--col-->
			</div><!--row-->
		</div><!--content-->

@endsection