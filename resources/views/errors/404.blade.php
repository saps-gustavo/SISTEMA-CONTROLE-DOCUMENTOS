@extends('layouts.login')

@section('content')
            
    <div class="row">
        <div class="card-panel" id="panel-login">
            <div class="row">
                <div class="input-field col s12 center">
                    <img src="/assets/imagens/logo.png" alt="" class="responsive-img">
                </div>
            </div>
            <div class="row">
                <div class="col s12 center">
                    <h5>Ops! O link que você acessou não foi encontrado.</h5>
                    <p>
                        Clique no link abaixo e acesse novamente.
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col s12 center">
                    <a href="/login" class="btn grey waves-effect waves-green">Acessar Novamente</a>
                </div>
            </div>
        </div>
    </div>
@endsection

