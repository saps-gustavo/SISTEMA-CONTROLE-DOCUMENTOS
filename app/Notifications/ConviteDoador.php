<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailable;

class ConviteDoador extends Mailable
{
    use Queueable, SerializesModels;

    protected $data;

    public function __construct($nome, $convite)
    {
        $this->data = [
            'nome' => $nome,
            'convite' => $convite,
            'linhas' => [
                    $convite.' convidou você para se juntar a nós e ser um doador.',
                    'Seja um colaborador e doe aos que mais necessitam.'
            ],
            'url' => getenv('APP_URL').'/register',
            'textoUrl' => 'Quero ser um Doador'
        ];
    }

    public function build()
    {
        return $this->from(env('MAIL_FROM_ADDRESS'))
                    ->subject(config('app.name')." ".config('app.surname')." - ".$this->data['convite']." enviou um convite para você!")
                    ->markdown('layouts._includes.emails.email_convite_template')
                    ->with('data', $this->data);
    }
}



