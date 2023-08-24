@component('mail::message')
    {{-- Greeting --}}
    @if (! empty($greeting))
        # {{ $greeting }}
    @else
        @if ($level == 'error')
            # Ocorreu um erro!
        @else
            # Olá!
        @endif
    @endif

    {{-- Intro Lines --}}
    @foreach ($introLines as $line)
        {{ $line }}
    @endforeach

    {{-- Action Button --}}
    @isset($actionText)
        <?php
            switch ($level) {
                case 'success':
                    $color = 'green';
                    break;
                case 'error':
                    $color = 'red';
                    break;
                default:
                    $color = 'blue';
            }
        ?>
        @component('mail::button', ['url' => $actionUrl, 'color' => 'green'])
            {{ $actionText }}
        @endcomponent
    @endisset

    {{-- Outro Lines --}}
    @foreach ($outroLines as $line)
        {{ $line }}
    @endforeach

    {{-- Salutation --}}
    @if (! empty($salutation))
        {{ $salutation }}
    @else
        Obrigado,<br>{{ config('app.name') }}
    @endif

    {{-- Subcopy --}}
    @isset($actionText)
        @component('mail::subcopy')
        Se você está tendo problemas ao clicar no botão "{{ $actionText }}" , copie e cole a URL abaixo na barra de endereços do seu navegador: [{{ $actionUrl }}]({{ $actionUrl }})
        @endcomponent
    @endisset
@endcomponent
