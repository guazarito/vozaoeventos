@component('mail::message')
{{-- Greeting --}}
# Olá!


{{-- Intro Lines --}}
Você está recebendo este e-mail porque recebemos um pedido de redefinição de senha para sua conta.

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
@component('mail::button', ['url' => $actionUrl, 'color' => $color])
Redefinir senha
@endcomponent
@endisset

{{-- Outro Lines --}}
Se você não solicitou uma reinicialização da senha, nenhuma ação adicional será necessária.

{{-- Salutation --}}
@if (! empty($salutation))
{{ $salutation }}
@else
Att,<br>Vozão Eventos
@endif

{{-- Subcopy --}}
@isset($actionText)
@component('mail::subcopy')
Se estiver tendo problemas para clicar em "Redefinir senha", copie e cole o link abaixo
em seu navegador: [{{ $actionUrl }}]({{ $actionUrl }})
@endcomponent
@endisset
@endcomponent
