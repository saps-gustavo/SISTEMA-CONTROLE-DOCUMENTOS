<?php // Same as error_reporting(E_ALL);
ini_set('error_reporting', E_ALL); ?>
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
    
    {{-- Estilos --}}
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Slab&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/materialize.min.css">
    <link rel="stylesheet" href="/assets/css/page-center.css">
    <link rel="stylesheet" href="/assets/css/style.min.css">
    <link rel="stylesheet" href="/assets/css/icon.css">
    <style>
        body {
            font-family: 'Roboto Slab', sans-serif;
        }
    </style>
    @yield('custom_css')
    {{-- Scripts --}}
    <script>
    window.Laravel = <?php echo json_encode([
        'csrfToken' => csrf_token(),
    ]); ?>
    </script>
</head>

<body style="background-color: #00796b !important;">

    {{-- Seção de conteúdo --}}

    {{-- Conteúdo --}}
    
    @yield('content')

    {{-- Scripts --}}
    <script type="text/javascript" src="/assets/js/jquery-3.6.3.min.js"></script>
    <script src="/assets/js/materialize.min.js"></script>
    <script src="/assets/js/custom.js"></script>
    <script src="/assets/js/formatter.js"></script>

    <script>
        function isNumber(evt)
        {
            var charCode = (evt.which) ? evt.which : event.keyCode
            if (charCode > 31 && (charCode < 48 || charCode > 57))
                return false;

            return true;
        }
    </script>
    
    @yield('scripts_login')

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

</body>
</html>
