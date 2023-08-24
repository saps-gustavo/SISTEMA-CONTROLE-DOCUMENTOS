@extends('layouts.app')

@section('conteudo')

@section('breadcrumb')
	<a class="breadcrumb" href="{{url('/')}}">{{ $titulo }}</a>
	<a class="breadcrumb" href="{{ route('admin.log') }}">{{ $subtitulo }}</a>
	<a class="breadcrumb"> Detalhes </a>
	@include('layouts._includes.home.notificacoes')
@endsection

<div class="row">
	<div class="col s12">
		<p> <span>ID:</span> {{$log->id_log_atividade}} </p>
		<p> <span>Ação:</span> {{$log->acao}} </p>
		<p> <span>URL:</span> {{ $log->url }} </p>
		<p> <span>Método:</span> {{ $log->metodo }} </p>
		<p> <span>IP:</span> {{ $log->ip }} </p>
		<p> <span>Fonte:</span> {{ $log->fonte}} </p>
		<p> <span>Criado em:</span> {{$log->created_at }} </p>
		<p> <span>Alterado em:</span> {{ $log->updated_at }} </p>
		<p> <span>Usuário:</span> {{$log->usuario->nome_usuario}} </p>
		<p> <span>Dados:</span> {{$log->dados}} </p>
	</div>
</div>
<div class="row">
	<div class="col s12">
		<a class="btn btn-default waves-effect waves-light right" href="javascript:history.back(-1);" tabindex="4">Voltar</a>
	</div>
</div>
@endsection

@section('custom_css')
	<style>
		p{word-break: break-all;}
		p > span{font-weight: bold;}
	</style>
@endsection
