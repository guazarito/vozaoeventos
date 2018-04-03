@extends('layout')

@section('content')

	 <link href="{{asset('layout/css/bootstrap-editable.css')}}" rel="stylesheet">
     <script src="{{asset('layout/js/bootstrap-editable.js')}}"></script>
	 <script src="{{asset('js/meusdados.js')}}"></script>


<div class="container meus_pedidos">
	<h1 id="meuspedidos_title">Meus Dados</h1>
	<br>
@if (sizeof($eu)>0)

	  	<p>Nome: <a href="#" title="Clique para editar" class="editable_field" data-type="text" data-pk="{{$eu->id}}" data-url="{{ route('adm.edita_meusdados_inline', ['name',$eu->id])}}">{{$eu->name}}</a></p>
		<p>CPF: {{$eu->cpf}}</p>
		<p>email: {{$eu->email}}</p>
		<p>Celular: <a href="#" title="Clique para editar" class="editable_field" data-type="text" data-pk="{{$eu->id}}" data-url="{{ route('adm.edita_meusdados_inline', ['celular',$eu->id])}}">{{$eu->celular}}</a></p>

	


@else
<p>Nenhum dado encontrado.</p>
<style>
  #footer{
  position: absolute;
  bottom: 0;
  }
</style>
@endif
</div><!--container-->

@if (sizeof($eu)==1)
<style>
 #footer{
  position: absolute;
  bottom: 0;
  }
</style>
@endif


@endsection