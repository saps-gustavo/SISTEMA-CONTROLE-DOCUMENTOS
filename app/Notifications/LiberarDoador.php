<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailable;

class LiberarDoador extends Mailable
{
    use Queueable, SerializesModels;

    protected $usuario;

    public function __construct($usuario)
    {
        $this->usuario = $usuario;
    }

    public function build()
    {
        return $this->from(env('MAIL_FROM_ADDRESS'))
                    ->subject(config('app.name')." ".config('app.surname')." - ".$this->usuario->nome_usuario." Seja bem-vindo!")
                    ->markdown('layouts._includes.emails.email_liberacao_template')
                    ->with('data', $this->usuario);
    }

}


