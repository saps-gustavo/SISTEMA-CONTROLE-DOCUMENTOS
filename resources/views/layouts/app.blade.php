<?php
    ini_set('error_reporting', E_ALL);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/assets/imagens/favicon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    {{-- CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name')}} {{ config('app.surname') }}</title>
    {{-- Favicon --}}
    <link rel="apple-touch-icon" sizes="57x57" href="/assets/imagens/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/assets/imagens/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/assets/imagens/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/assets/imagens/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/assets/imagens/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/assets/imagens/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/assets/imagens/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/assets/imagens/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/imagens/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="/assets/imagens/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/imagens/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/assets/imagens/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/imagens/favicon/favicon-16x16.png">
    <link rel="manifest" href="/assets/imagens/favicon/manifest.json">
    {{-- Estilos --}}
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@300;400;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/icon.css">
    <link rel="stylesheet" href="/assets/css/materialize.min.css">
    <link rel="stylesheet" href="/assets/css/animate.min.css">
    <link rel="stylesheet" href="/assets/css/custom.css">
    <link rel="stylesheet" href="/assets/css/personalizado.css">
    <link rel="stylesheet" href="/assets/css/table-box.css">
    <link rel="stylesheet" href="/assets/css/card-modelo.css">
    <link rel="stylesheet" href="/assets/css/timeline.css">
    @yield('custom_css')
    {{-- Scripts --}}
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body class="grey lighten-3" id="topo-body-page">

    @include('layouts._includes.loading')

    {{-- Navegação --}}
    <header id="topo">
        <nav class="nav-figma">
            <div class="container">
                {{-- Botão de menu mobile --}}
                <a data-target="nav-mobile" class="sidenav-trigger"><i class="material-icons">menu</i></a>
                {{-- Estrutura do menu lateral --}}

                <ul id="nav-mobile" class="sidenav sidenav-fixed">
                    {{-- Informações do usuário --}}
                    @if(Auth::check())
                        <li>
                            <div id="user-view" class="user-view teal darken-2">
                                <a><span class="white-text name">{{ 'Bem-vindo(a), '. Auth::user()->getPrimeiroNome() }}</span></a>
                                <a href="{{ url('/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><span class="white-text email truncate">Sair</span></a>
                            </div>
                            <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>                    
                    @endif

                    @if (env('AMBIENTE')=='TESTE')
                        <div class="card-panel red">
                            <span class="white-text">
                                <p align="center"><h6>AMBIENTE DE TESTE</h6></p>
                            </span>
                        </div>
                    @endif
                    
                    <li><img src="/assets/imagens/logo.png" alt="" class="responsive-img valign profile-image-login"></li>

                    @if(Auth::check())
                        {{-- CARREGA O MENU DO BD --}}
                        @foreach(App\Menu::arvoreMenu(null) as $menu)
                            @if(isset($menu->filhos) && $menu->filhos->count() > 0 )
                                <li>
                                    <ul class="collapsible collapsible-accordion">
                                        <li><a class="collapsible-header {{$menu->classe_menu}}"><i class="material-icons">{{$menu->icone_menu}}</i><span class="label-menu">{{$menu->label_menu}}</span><i class="material-icons dropdown right">arrow_drop_down</i></a>
                                            <div class="collapsible-body">
                                                <ul>
                                                    @include('layouts._includes.menuPartial', ['menus' => $menu->filhos])
                                                </ul>
                                            </div>
                                        </li>
                                    </ul>
                                </li>
                            @else
                                <li >
                                    <a href="{{ $menu->url_menu ? route((string)$menu->url_menu) : '' }}" class="{{$menu->classe_menu}} @if(!isset($menu->target_menu)) dispara-loading @endif" target="{{$menu->target_menu}}"><i class="material-icons">{{$menu->icone_menu}}</i>{{$menu->label_menu}}</a>
                                </li>
                            @endif
                        @endforeach
                    @else
                        <li><a href="/" class="collapsible-header waves-effect"><i class="material-icons">backspace</i>Voltar</a></li>
                    @endif
                </ul>
                {{-- FIM MENU --}}

                {{-- Título da aplicação --}}
                <div class="nav-wrapper">
                    <a class="app-title">{{ config('app.name')}} {{ config('app.surname')}}</a>
                </div>
            </div>
        </nav>
        {{-- Breadcrumb de seções --}}
        <nav class="teal lighten-1">
            <div class="container">
                <div class="nav-wrapper">
                    <div class="col s12">
                        @yield('breadcrumb')
                    </div>
                </div>
            </div>
        </nav>
    </header>
    
    {{-- Seção de conteúdo --}}

    <main>
        @yield('fab')
        @yield('modalAdicionar')
        @yield('modal')
        <div class="container" >
            {{-- Conteúdo --}}
            @yield('conteudo')
        </div>
    </main>

    @include('layouts._includes.footer')
    
    {{-- Scripts --}}
    <script type="text/javascript" src="/assets/js/jquery-3.6.3.min.js"></script>
    <script src="/assets/js/materialize.min.js"></script>
    <script src="/assets/js/custom.js"></script>
    <script src="/assets/js/formatter.js"></script>
    <script src='/assets/js/tinymce/tinymce.min.js'></script>
    
    <script>

        $('.dropdown-trigger').dropdown();
        $(document).ready(function()
        {
            Number.isInteger = Number.isInteger || function(value) {
                return typeof value === 'number' &&
                isFinite(value) &&
                Math.floor(value) === value;
            };

            $('.sidenav').sidenav();
        });
    </script>
    @include('scripts.ajax_login_redirect')
    
    @yield('script')
    @yield('script2')
    {{-- Mensagens de retorno de operação --}}
    @if(Session::has('mensagem'))
        <script type="text/javascript">
            $(window).on('load',function() {
                setTimeout(function() {
                    var html_msg = '<span>{{ Session::get("mensagem")["msg"] }}</span>';
                    var css_erro_class = '{{ array_key_exists("erro", Session::get("mensagem")) ? "red" : "" }}';
                    M.toast({html: html_msg, classes: 'rounded ' + css_erro_class, displayLength: 5000});
                }, 1800);
            });
        </script>
    @endif
    <script>
        function isNumber(evt)
        {
            var charCode = (evt.which) ? evt.which : event.keyCode
            if (charCode > 31 && (charCode < 48 || charCode > 57))
                return false;

            return true;
        }
    </script>
    
    <script>
        function maiuscula(z){      
            v = z.value.toUpperCase();
            z.value = v;
        }
    </script>

    <script>
        $("#div-loading-body").hide();
    </script>
    <script>
		$(document).ready(function() {
			$('.dispara-loading').click(function() {
				$("#div-loading-body").show();
			});
		});
	</script>
</body>
</html>
