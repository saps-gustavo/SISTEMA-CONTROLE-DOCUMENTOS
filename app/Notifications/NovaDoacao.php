<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailable;

class NovaDoacao extends Mailable
{
    use Queueable, SerializesModels;

    protected $data;

    public function __construct($nome, $mensagem)
    {
        $this->data = [
            'nome' => $nome,
            'linhas' => [
                    $mensagem
            ],
            'url' => getenv('APP_URL').'/doacao/listar',
            'textoUrl' => 'Ver Doação'
        ];
    }

    public function build()
    {
        return $this->from(env('MAIL_FROM_ADDRESS'))
                    ->subject(config('app.name')." ".config('app.surname')." - Nova Doação!")
                    ->markdown('layouts._includes.emails.email_nova_doacao_template')
                    ->with('data', $this->data);
    }
}



