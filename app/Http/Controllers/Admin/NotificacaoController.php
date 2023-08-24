<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Notificacao;
use App\Models\Entidade;

class NotificacaoController extends Controller
{
    public function index()
    {
        // Pega o usuário logado
		$usuario = auth()->user();
		
		// Pega o objeto entidade desse usuário
		$registro = Entidade::where('id_usuario', $usuario->id_usuario)->first();

		if(isset($registro)){

			// Usuário ENTIDADE, DOADOR e FAMÍLIA - Tem notificação

			$lista = Notificacao::where('id_entidade', $registro->id_entidade)
                                ->where('status', 1)
                                ->orderBy('created_at', 'desc')->get();

            foreach($lista as $item){
                // Passa para lido (se quiser deletar, também pode)
                //$item->status = 0;
                //$item->save();
                $item->delete();
            }

		}else{

			// Usuário SEDH ou SAPS - Não tem notificação
            $lista = [];
		}

        $titulo = "Notificações";
        $subtitulo = "Página Inicial";
        
        return view('admin.notificacao', compact('lista', 'titulo', 'subtitulo'));
    }

    public function total()
    {
        try{
            // Pega o usuário logado
            $usuario = auth()->user();
            
            // Pega o objeto entidade desse usuário
            $registro = Entidade::where('id_usuario', $usuario->id_usuario)->first();

            $total = 0;

            if(isset($registro)){

                // Usuário ENTIDADE, DOADOR e FAMÍLIA - Tem notificação

                $total = Notificacao::where('id_entidade', $registro->id_entidade)
                                    ->where('status', 1)
                                    ->count();

            }

            return response()->json(
                [
                    'status' => true,
                    'mensagem' => null,
                    'total' => $total
                ], 200);
            
        }
        catch(\Exception $e)
        {
            return response()->json(
                [
                    'status' => false,
                    'mensagem' => $e->getMessage(),
                    'total' => 0
                ], 200);
        }
    }
}

