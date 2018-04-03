@extends('layout')

@section('content')


	 <link href="{{asset('layout/css/bootstrap-editable.css')}}" rel="stylesheet">
     <script src="{{asset('layout/js/bootstrap-editable.js')}}"></script>
	 <script src="{{asset('js/admPrecos.js')}}"></script>

	  
 <div class="container">
	<button type="button" id="add_preco" class="btn btn-default"><spam class="glyphicon glyphicon-plus"></spam> Adicionar linha</button>
	<form id="form_precos">
	 {{ csrf_field() }}
		<ul id="ul_precos">
			<li class="li_precos" id="1">
				Lote: 	
				<select name="lote1">
					<option value="0" selected></option>
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="99">99 (teste cartão)</option>
				</select>
				Preço: R$ <input type="text" name="preco1"></input>
			</li>
		</ul>
		<button type="button" id="btnSalvar" class="btn btn-primary">Salvar Preço/Lote</button>
		<button type="button" id="btnLimpar" class="btn btn-default">Limpar</button>
	</form>
			<br><br><br>
	Lote atual:
	<select name="lote_atual">
		<option value="0" ></option>
		@if(sizeof($lotes)>0)
			@foreach($lotes as $lote)
				<?php
				$selected = "";
				if(sizeof($lote_atual)>0){
					if( $lote->lote==$lote_atual->lote_atual){
						$selected = "selected";
					}
				}
				?>
				<option value="{{$lote->lote}}" {{$selected}}>{{$lote->lote}}</option>
			@endforeach
		@endif
	</select>

	<button type="button" id="btnSalvaLoteAtual" class="btn btn-xs btn-success">
		<span class="glyphicon glyphicon-floppy-disk"></span> Salvar lote atual
	</button>

	
	@if( sizeof($precos)>0)
	 <table class="table table-hover table-striped">
        <thead>
        <tr>
            <th>Lote</th>
            <th>Preço</th>
            <th>Excluir</th>
        </tr>
        </thead>
        <tbody>
        @foreach($precos as $preco)
        <tr>
            <td>
                <p>{{$preco->lote}}</p>
            </td>
			<td>
				R$ <a href="#" title="Clique para editar" class="editable_field" data-type="text" data-pk="{{$preco->id}}" data-url="{{ route('adm.edita_preco_inline', $preco->id)}}">{{str_replace(".",",",number_format($preco->preco,2))}}</a>
			</td>
			<td>
				<button type="button" id="btnExcluir" onclick="excluir({{$preco->id}})" class="btn btn-default">Excluir</button>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
	@else
		<p>nenhum preco cadastrado</p>		
	@endif

</div>
@endsection