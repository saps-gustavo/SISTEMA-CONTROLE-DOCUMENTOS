<?php

namespace App\Http\Controllers\SEDH;

use App\Models\TipoTermoAdministrativo;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Bouncer;

use App\Http\Requests\SEDH\TipoTermoAdministrativoRequest;


use Illuminate\Support\Facades\DB;

class TipoTermosAdministrativosController extends Controller
{
	public function index(Request $request)
	{
		try{
			if(!auth()->user()->can('tipo_termo_administrativo_consultar')){
				\Session::flash('mensagem',['msg'=>'Você não tem permissão para listar esses registros.']);
				return redirect('/');
			}

			$lista = TipoTermoAdministrativo::query();

			// Total de Registros
			$qtd_registros = $lista->count();

			// Buscas e filtros
			$parametros = $request->all();

			// Descrição: desc_motivo_avaria
			if (isset($parametros['busca_desc'])) {
				$desc = $parametros['busca_desc'];
				//passagem numa função anônima para que as claúsulas sejam colocadas entre parenteses
				$lista = $lista->where(function ($query) use ($desc) {
					$query->where(\DB::raw('to_ascii(desc_resumida_ato_adm)'), 'ilike', '%'.trocaAcento($desc).'%');
				});
			}

			$lista = $lista->orderBy('desc_resumida_ato_adm')->paginate(getenv('paginacao'))->appends($request->query());

			$titulo = "Principal";
			$subtitulo = "Tipo Termos Administrativo";

			return view('sedh.tipo_termos_administrativos.index', compact('lista', 'titulo', 'subtitulo','qtd_registros'));

		}catch(\Exception $e)
		{
			$msg = str_replace("\n", "", $e->getMessage());
			\Session::flash('mensagem',['erro' => true, 'msg'=>$msg]);

			return redirect('/');
		}
	}

	public function formulario($id = null, $uniqid = null)
	{
		try{
			$registro = null;
			$subtitulo = "";

			//verifica se é uma operação de edição ou inserção e inicializa objeto
			if(isset($id))
			{
				// Somente Números
				$id = preg_replace("/\D/","", $id);

				$hab 	= 	'tipo_termo_administrativo_editar';
				$op 	= 	'editar';
				$registro = TipoTermoAdministrativo::find($id);
				$subtitulo = "Editar";

				// Verifica se existe o registro
				if(!isset($registro)){
					\Session::flash('mensagem',['erro' => true, 'msg'=>'Registro não encontrado.']);
					return back()->withInput();
				}

				// Verifica se o uniqid do registro é igual ao passado
				$uniq_id = $uniqid;

				if($uniq_id != $registro->uniqid){
					\Session::flash('mensagem',['erro' => true, 'msg'=>'Permissão negada! Tente novamente.']);
					return back()->withInput();
				}
			}
			else
			{
				$hab 	= 	'tipo_termo_administrativo_adicionar';
				$op 	= 	'adicionar';
				$registro = new TipoTermoAdministrativo();
				$subtitulo = "Adicionar";

				$registro->uniqid = '0';
			}
			//verifica permissão

			if(!auth()->user()->can($hab)){
				\Session::flash('mensagem',['msg'=>'Você não tem permissão para '.$op.' esse registro.']);
				return redirect('/');
			}
			
			//breadcrumb
			$titulo = "Tipo Termos Adm";

			//associações
			$perfis = Bouncer::role()->orderBy('name')->get();

			return view('sedh.tipo_termos_administrativos.formulario', compact('registro','titulo','subtitulo','perfis'));

		}catch(\Exception $e)
		{
			$msg = str_replace("\n", "", $e->getMessage());
			\Session::flash('mensagem',['erro' => true, 'msg'=>$msg]);

			return redirect('/');
		}
	}

	public function salvar(TipoTermoAdministrativoRequest $request)
	{
		try
		{
			$data = $request->all();

			if(isset($data['cod_tipo_termo_adm']))
			{
				// Somente Números
				$id = preg_replace("/\D/","", $data['cod_tipo_termo_adm']);

				$registro = TipoTermoAdministrativo::find($id);
				$hab  =   'tipo_termo_administrativo_editar';
				$op   =   'editar';
				$msg = "Registro alterado com sucesso!";

				// Verifica se existe o registro
				if(!isset($registro)){
					\Session::flash('mensagem',['erro' => true, 'msg'=>'Registro não encontrado.']);
					return back()->withInput();
				}

				// Verifica se o uniqid do registro é igual ao passado
				$uniq_id = $data['uniqid'];
				//dd($uniq_id);

				if($uniq_id != $registro->uniqid){
					\Session::flash('mensagem',['erro' => true, 'msg'=>'Permissão negada! Tente novamente.']);
					return back()->withInput();
				}

			}
			else
			{
				$registro = new TipoTermoAdministrativo();
				$hab  =   'tipo_termo_administrativo_adicionar';
				$op   =   'adicionar';
				$msg = "Registro inserido com sucesso!";

				// Gera o ID único para esse registro
				$data['uniqid'] = time().'-'.uniqid();

			}

			if(!auth()->user()->can($hab))
			{
				\Session::flash('mensagem',['msg'=>'Você não tem permissão para '.$op.' esse registro.']);
				return redirect('/');
			}

			$registro->fill($data);
			$registro->save();

			\Session::flash('mensagem',['msg'=>$msg]);
			
			return redirect()->route('sedh.tipo_termos_administrativos');
		}
		catch(\Exception $e)
		{
			if($e->getCode() == 23505){
                $msg = 'Já existe um registro com os valores informados. Favor conferir os campos únicos.';
                \Session::flash('mensagem',['erro' => true, 'msg'=>$msg]);
            }else{
                $msg = str_replace("\n", "", $e->getMessage());
                \Session::flash('mensagem',['erro' => true, 'msg'=>$msg]);
            }
            return back()->withInput(); 
		}
	}
	public function excluir(TipoTermoAdministrativoRequest $request)
	{
		try
		{	
			if(!auth()->user()->can('tipo_termo_administrativo_excluir')){
				return response()->json(
					[
						'status' => false,
						'mensagem' => 'Você não tem permissão para excluir esse registro.'
					], 200);
			}
			
			// Somente Números
			$id = preg_replace("/\D/","", $request->input('id'));

			$registro = TipoTermoAdministrativo::find($id);

			// Verifica se existe o registro
			if(!isset($registro)){
				return response()->json(
					[
						'status' => false,
						'mensagem' => 'Registro não encontrado',
					], 200);
			}

			// Verifica se o uniqid do registro é igual ao passado
			$uniq_id = $request->input('uniqid');

			if($uniq_id != $registro->uniqid){
				return response()->json(
					[
						'status' => false,
						'mensagem' => 'Permissão negada! Tente novamente.',
					], 200);
			}

			DB::transaction(function () use ($registro) {
				$registro->delete();
			});

			\Session::flash('mensagem',['msg'=>'Registro excluído com sucesso!']);
			return response()->json(
				[
					'status' => true,
					'mensagem' => 'Registro excluído com sucesso'
				], 200);

		}
		catch(\Exception $e)
		{
			if($e->getCode() == 23503){

				return response()->json(
					[
						'status' => false,
						'mensagem' => 'Esse registro não pode ser excluído pois já está relacionado a outros.'
					], 200);

			}else{

				return response()->json(
					[
						'status' => false,
						'mensagem' => $e->getMessage()
					], 200);
			}
		}
	}
}
