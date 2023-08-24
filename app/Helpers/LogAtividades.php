<?php

namespace App\Helpers;
use Request;
use App\LogAtividades as LogAtividadeModel;

class LogAtividades
{
    public static function adicionaAoLog($subject, $dados = 'Não aplicável/Vazio')
    {
    	$log = [];
    	$log['acao'] = $subject;
    	$log['url'] = Request::fullUrl();
    	$log['metodo'] = Request::method();
    	$log['ip'] = Request::ip();
    	$log['fonte'] = Request::header('user-agent');
    	$log['id_usuario'] = auth()->check() ? auth()->user()->id_usuario : 1;
        $log['dados'] = $dados;

        LogAtividadeModel::create($log);
    }

    public static function logAtividadeListas()
    {
    	return LogAtividadeModel::latest()->paginate(10);
    }

}