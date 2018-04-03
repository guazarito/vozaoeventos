@extends('layout')

@section('content')
<div class="container meus_pedidos">
	<h1 id="meuspedidos_title">Usuários</h1>
	<br>
@if (sizeof($users)>0)
	<?php $i=0; ?>
	<table class="table" style="border-bottom:2px solid #dddddd;">
	  <thead>
	    <tr>
	      <th>ID</th>
	      <th>Nome</th>
	      <th>CPF</th>
	      <th>Email</th>
	      <th>Celular</th>
	      <th>Data do Cadastro</th>
	    </tr>
	  </thead>
	  <tbody>
	  	@foreach($users as $user)

	    <tr>
	      <th scope="row">{{$user->id}}</th>
	      <td>{{$user->name}}</td>
	      <td>{{$user->cpf}}</td>
	      <td>{{$user->email}}</td>
	      <td>{{$user->celular}}</td>
	      <td>{{date_format($user->created_at,"d/m/Y")}}</td>
	    </tr>
	    @endforeach
	  </tbody>
	</table>

@else
<p>Nenhum user encontrado.</p>
<style>
  #footer{
  position: absolute;
  bottom: 0;
  }
</style>
@endif
</div><!--container-->


@endsection