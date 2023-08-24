<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Bouncer;
use App\Http\Requests\HabilidadeRequest;
use App\Funcionalidade;

class HabilidadeController extends Controller
{
    public function index(Request $request)
    {
        if (!auth()->user()->can('habilidade_listar')) {
            \Session::flash('mensagem', ['msg'=>'Você não tem permissão para listar habilidades.']);
            return redirect('/');
        }

        $qtd_habilidades = Bouncer::ability()->all()->count();
        $habilidades = Bouncer::ability();

        //buscas e filtros
        $parametros = $request->all();

        //nome
        if (isset($parametros['busca_nome'])) {
            $nome = $parametros['busca_nome'];
            //passagem numa função anônima para que as claúsulas sejam colocadas entre parenteses
            $habilidades = $habilidades->where(function ($query) use ($nome) {
                $query->where(\DB::raw('to_ascii(name)'), 'ilike', '%'.trocaAcento($nome).'%');
            });
        }

        //cpf
        if (isset($parametros['busca_titulo'])) {
            $titulo = $parametros['busca_titulo'];
            //passagem numa função anônima para que as claúsulas sejam colocadas entre parenteses
            $habilidades = $habilidades->where(function ($query) use ($titulo) {
                $query->where(\DB::raw('to_ascii(title)'), 'ilike', '%'.trocaAcento($titulo).'%');
            });
        }

        $habilidades = $habilidades->orderBy('name')->paginate(8000);
        $titulo = "Principal";
        $subtitulo = "Habilidades";
        return view('admin.habilidade.index', compact('habilidades', 'titulo', 'subtitulo', 'qtd_habilidades'));
    }
    public function formulario($id = null, Request $request)
    {
        $data = $request->all();
        //verifica se é uma operação de edição ou inserção e inicializa objeto
        if (isset($id)) {
            $hab 	= 	'habilidade_editar';
            $op 	= 	'editar';
            $habilidade = Bouncer::ability()->find($id);
            $subtitulo = "Editar Habilidade ".$habilidade->name;
        } else {
            $hab 	= 	'habilidade_adicionar';
            $op 	= 	'adicionar';
            $habilidade = Bouncer::ability();
            $subtitulo = "Adicionar Nova Habilidade";
        }
        //verifica permissão
        if (!auth()->user()->can($hab)) {
            \Session::flash('mensagem', ['msg'=>'Você não tem permissão para '.$op.' habilidades.']);
            return redirect('/');
        }
        //breadcrumb
        $titulo = "Habilidades";
        return view('admin.habilidade.formulario', compact('habilidade', 'titulo', 'subtitulo'));
    }

    public function salvar(HabilidadeRequest $request)
    {
        $data = $request->all();
        if (isset($data['id'])) {
            $habilidade = Bouncer::ability()->find($data['id']);
            $hab  =   'habilidade_editar';
            $op   =   'editar';
            $msg = "Registro alterado com sucesso!";
        } else {
            $habilidade = Bouncer::ability();
            $hab  =   'habilidade_adicionar';
            $op   =   'adicionar';
            $msg = "Registro incluído com sucesso!";
        }

        if (!auth()->user()->can($hab)) {
            \Session::flash('mensagem', ['msg'=>'Você não tem permissão para '.$op.' habilidades.']);
            return redirect('/');
        }
        $habilidade->fill($data);
        $habilidade->save();
        \Session::flash('mensagem', ['msg'=>$msg]);
        return redirect()->route('admin.habilidade');
    }
    public function excluir(Request $request)
    {
        try {
            if (!auth()->user()->can('habilidade_excluir')) {
                \Session::flash('mensagem', ['msg'=>'Você não tem permissão para excluir habilidades.']);
                return redirect('/');
            }
            $id =  $request->input('id_habilidade');
            $habilidade = Bouncer::ability()->find($id);
            $habilidade->delete();

            return response()->json(
                [
                    'status' => true,
                    'mensagem' => 'Registro excluído com sucesso'
                ], 200);

            \Session::flash('mensagem',['msg'=>'Registro excluído com sucesso']);

        } catch (QueryException $e) {
            return response()->json(
                [
                    'status' => false,
                    'mensagem' => queryExceptionMessage($e),
                ],
                200
            );
        } catch (\Exception $e) {
            return response()->json(
                [
                    'status' => false,
                    'mensagem' => $e->getMessage()
                ],
                200
            );
        }
    }

    public function ajaxSelectHabilidade(Request $request)
    {
        try {
            if (!auth()->user()->can('habilidade_listar')) {
                return response()->json(
                    [
                        'status' => false,
                        'mensagem' => 'Você não tem permissão para listar habilidades'
                    ]
                );
            }

            $habilidades = Funcionalidade::getHabilidadesWithFuncionalidade()->toJson();

            return $habilidades;
        } catch (Exception $e) {
            return response()->json(
                [
                    'status' => false,
                    'mensagem' => $e->getMessage()
                ],
                200
            );
        }
    }

    public function salvarAjax(HabilidadeRequest $request)
    {
        try {
            $data = $request->all();


            $habilidade = Bouncer::ability();
            $hab  =   'habilidade_adicionar';
            $op   =   'adicionar';

            if (!auth()->user()->can($hab)) {
                return response()->json(
                    [
                        'status' => false,
                        'mensagem' => 'Você não tem permissão para adicionar habilidades'
                    ]
                );
            }

            $habilidade->fill($data);
           // dd($data);
            $habilidade->save();

            return response()->json([
                'status' => true,
                'mensagem' => 'Habilidade gravada com sucesso',
                'id' => $habilidade->id
            ]);
        } catch (\Exception $e) {
            return response()->json(
                [
                    'status' => false,
                    'mensagem' => $e->getMessage()
                ]
            );
        }
    }
}
