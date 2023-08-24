<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Bouncer;
use App\Http\Requests\FuncionalidadeRequest;
use App\Funcionalidade;
use Illuminate\Support\Facades\Input;

class FuncionalidadeController extends Controller
{
    public function index(Request $request)
    {
        if (!auth()->user()->can('funcionalidade_listar')) {
            \Session::flash('mensagem', ['msg'=>'Você não tem permissão para listar funcionalidades.']);
            return redirect('/');
        }

        $qtd_funcionalidades = Bouncer::ability()->all()->count();
        $funcionalidades = Funcionalidade::query();

        //buscas e filtros
        $parametros = $request->all();

        //nome
        if (isset($parametros['busca_nome'])) {
            $nome = $parametros['busca_nome'];
            //passagem numa função anônima para que as claúsulas sejam colocadas entre parenteses
            $funcionalidades = $funcionalidades->where(function ($query) use ($nome) {
                $query->where(\DB::raw('to_ascii(nome_funcionalidade)'), 'ilike', '%'.trocaAcento($nome).'%');
            });
        }

        $funcionalidades = $funcionalidades->orderBy('nome_funcionalidade')->paginate(8);
        $titulo = "Principal";
        $subtitulo = "Funcionalidades";
        return view('admin.funcionalidade.index', compact('funcionalidades', 'titulo', 'subtitulo', 'qtd_funcionalidades'));
    }

    public function formulario($id = null, Request $request)
	{
		$data = $request->all();

        //verifica se é uma operação de edição ou inserção e inicializa objeto
		if(isset($id))
		{
			$hab 	= 	'funcionalidade_editar';
			$op 	= 	'editar';
			$funcionalidade = Funcionalidade::find($id);
			$subtitulo = "Editar Funcionalidade ".$funcionalidade->nome_funcionalidade;
		}
		else
		{
			$hab 	= 	'funcionalidade_adicionar';
			$op 	= 	'adicionar';
			$funcionalidade = new Funcionalidade();
			$subtitulo = "Adicionar Novo Funcionalidade";
		}
        //verifica permissão
		if(!auth()->user()->can($hab)){
			\Session::flash('mensagem',['msg'=>'Você não tem permissão para '.$op.' funcionalidades.']);
			return redirect('/');
		}

        //breadcrumb
		$titulo = "Funcionalidades";
        //associações
	    $habilidades = Funcionalidade::getHabilidadesWithFuncionalidade();

		return view('admin.funcionalidade.formulario', compact('funcionalidade','titulo','subtitulo','habilidades'));
	}

	public function salvar(FuncionalidadeRequest $request)
	{

        $data = $request->all();
            
        if(isset($data['id_funcionalidade']))
        {
            $funcionalidade = Funcionalidade::find($data['id_funcionalidade']);
            $hab 	= 	'funcionalidade_editar';
            $op 	= 	'editar';
            $msg = "Registro alterado com sucesso!";
        }
        else
        {
            $funcionalidade = new Funcionalidade();
            $hab 	= 	'funcionalidade_adicionar';
            $op 	= 	'adicionar';
            $msg = "Registro incluído com sucesso!";
        }
        if(!auth()->user()->can($hab))
        {
            \Session::flash('mensagem',['msg'=>'Você não tem permissão para '.$op.' usuários.']);
            return redirect('/');
        }

		\DB::transaction(function() use($funcionalidade, $data) {

            $funcionalidade->fill($data);
            $funcionalidade->save();
		});

        \Session::flash('mensagem',['msg'=>$msg]);
		return redirect()->route('admin.funcionalidade.formulario', $funcionalidade->id_funcionalidade);

	}

    public function excluir(Request $request)
    {
        try {
            if (!auth()->user()->can('funcionalidade_excluir')) {
                \Session::flash('mensagem', ['msg'=>'Você não tem permissão para excluir funcionalidades.']);
                return redirect('/');
            }

            $id =  $request->input('id_funcionalidade');

            \DB::transaction(function() use($id) {
            
                $funcionalidade = Funcionalidade::find($id);
                $funcionalidade->delete();
            });

            \Session::flash('mensagem',['msg'=>'Registro excluído com sucesso']);

            return response()->json(
            [
                'status' => true,
                'mensagem' => 'Registro excluído com sucesso'
            ], 200);

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

    public function associaHabilidade(Request $request)
    {
        try
        {
            if(!auth()->user()->can('funcionalidade_editar'))
            {
                \Session::flash('mensagem',['msg'=>'Você não tem permissão para a operação.']);
                return redirect('/');
            }

            $data = $request->all();

            if(isset($data['id_habilidade']))
            {
                $id_funcionalidade = $data['id_funcionalidade_habilidade'] ?? null;

                $habilidade = Bouncer::ability()::find($data['id_habilidade']);
                $habilidade->id_funcionalidade = $id_funcionalidade;

                \DB::transaction(function() use($habilidade, $data) {

                    $habilidade->fill($data);
                    $habilidade->save();
                });

                $aux = ($id_funcionalidade == null)?'de':'';

                return response()->json(
                    [
                        'status' => true,
                        'mensagem' => 'Habilidade '.$aux.'associada com Sucesso'
                    ], 200);
            }
            else
            {
                return response()->json(
                    [
                        'status' => false,
                        'mensagem' => 'Parâmetros Inválidos'
                    ], 200);
            }
        }
        catch(\Exception $e)
        {
            return response()->json(
                [
                    'status' => false,
                    'mensagem' => $e->getMessage()
                ], 200);
        }
    }

    public function carregaTabelaHabilidades()
    {
        if(!auth()->user()->can('funcionalidade_editar'))
        {
            \Session::flash('mensagem',['msg'=>'Você não tem permissão para a operação.']);
            return redirect('/');
        }

        $id_funcionalidade = Input::get('id_funcionalidade');

        $habilidades = Bouncer::ability()->where('id_funcionalidade',$id_funcionalidade)->orderBy('name')->get();

        return view('admin.funcionalidade._includes.habilidadesPorFuncionalidade',compact('habilidades'));

    }




}
