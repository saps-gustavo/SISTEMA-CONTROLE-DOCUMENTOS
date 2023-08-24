<?php

namespace App\Http\Controllers\SEDH;

use Illuminate\Http\Request;
use App\Http\Requests\SEDH\TermoAdministrativoRequest;

use App\Http\Controllers\Controller;
use App\Models\TermoAdministrativo;
use Bouncer;
use Illuminate\Support\Facades\DB;
use App\Models\TipoServico;
use App\Models\SituacaoTermoAdministrativo;
use App\Models\TipoTermoAdministrativo;
use App\Models\vwTermoAdministrativo;


class TermoAdministrativoController extends Controller
{
    public function index(Request $request)
	{
		try{
			if(!auth()->user()->can('termo_administrativo_consultar')){
				\Session::flash('mensagem',['msg'=>'Você não tem permissão para listar esses registros.']);
				return redirect('/');
			}

			//$lista = TermoAdministrativo::query();

			$lista = vwTermoAdministrativo::query();

			// Total de Registros
			$qtd_registros = $lista->count();

			// Buscas e filtros
			$parametros = $request->all();

			if (isset($parametros['cod_tipo_termo_adm'])) {
				$desc = $parametros['cod_tipo_termo_adm'];
				//passagem numa função anônima para que as claúsulas sejam colocadas entre parenteses
				$lista = $lista->where(function ($query) use ($desc) {
					$query->where('cod_tipo_termo_adm', $desc);

				});
			}

			if (isset($parametros['busca_desc_data'])) {
				$desc = $parametros['busca_desc_data'];
				//passagem numa função anônima para que as claúsulas sejam colocadas entre parenteses
				$lista = $lista->where(function ($query) use ($desc) {
					$query->where('dt_documento', $desc);

				});
			}

			if (isset($parametros['busca_desc_num_proc'])) {
				$desc = $parametros['busca_desc_num_proc'];
				//passagem numa função anônima para que as claúsulas sejam colocadas entre parenteses
				$lista = $lista->where(function ($query) use ($desc) {
					$query->where('num_proximo', $desc);

				});
			}

			if (isset($parametros['busca_desc_num_aditivo'])) {
				$desc = $parametros['busca_desc_num_aditivo'];
				//passagem numa função anônima para que as claúsulas sejam colocadas entre parenteses
				$lista = $lista->where(function ($query) use ($desc) {
					$query->where('num_aditivo', $desc);

				});
			}

			$tipo_termo_adm = TipoTermoAdministrativo::orderBy('desc_resumida_ato_adm')->get();

			$lista = $lista->orderBy('cod_ato_adm')->paginate(getenv('paginacao'))->appends($request->query());

			$titulo = "Principal";
			$subtitulo = "Termos Administrativos";

			return view('sedh.termo_administrativo.index', compact('lista', 'titulo', 'subtitulo','qtd_registros', 'parametros', 'tipo_termo_adm'));

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

				$hab 	= 	'termo_administrativo_editar';
				$op 	= 	'editar';
				$registro = TermoAdministrativo::find($id);
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
				$hab 	= 	'termo_administrativo_adicionar';
				$op 	= 	'adicionar';
				$registro = new TermoAdministrativo();
				$subtitulo = "Adicionar";

				$registro->uniqid = '0';
			}
			//verifica permissão

			if(!auth()->user()->can($hab)){
				\Session::flash('mensagem',['msg'=>'Você não tem permissão para '.$op.' esse registro.']);
				return redirect('/');
			}
			
			//breadcrumb
			$titulo = "Termos Administrativos";

			$tipo_servico = TipoServico::orderBy('desc_tipo_servico')->get();

			$situacao = SituacaoTermoAdministrativo::orderBy('desc_situacao')->get();

			$tipo_termo_adm = TipoTermoAdministrativo::orderBy('desc_resumida_ato_adm')->get();


			return view('sedh.termo_administrativo.formulario', compact('registro','titulo','subtitulo','tipo_servico', 'situacao', 'tipo_termo_adm'));

		}catch(\Exception $e)
		{
			$msg = str_replace("\n", "", $e->getMessage());
			\Session::flash('mensagem',['erro' => true, 'msg'=>$msg]);

			return redirect('/');
		}
	}

	public function salvar(TermoAdministrativoRequest $request)
	{
		try
		{
			$data = $request->all();

			if(isset($data['id_termo_adm']))
			{
				// Somente Números
				$id = preg_replace("/\D/","", $data['id_termo_adm']);

				$registro = TermoAdministrativo::find($id);
				$hab  =   'termo_administrativo_editar';
				$op   =   'editar';
				$msg = "Registro alterado com sucesso!";

				// Verifica se existe o registro
				if(!isset($registro)){
					\Session::flash('mensagem',['erro' => true, 'msg'=>'Registro não encontrado.']);
					return back()->withInput();
				}

				// Verifica se o uniqid do registro é igual ao passado
				$uniq_id = $data['uniqid'];

				if($uniq_id != $registro->uniqid){
					\Session::flash('mensagem',['erro' => true, 'msg'=>'Permissão negada! Tente novamente.']);
					return back()->withInput();
				}

			}
			else
			{
				$registro = new TermoAdministrativo();
				$hab  =   'termo_administrativo_adicionar';
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

			$data['dt_inicio'] = implode('-',array_reverse(explode('/', $data['dt_inicio'])));
			$data['dt_termino'] = implode('-',array_reverse(explode('/', $data['dt_termino'])));

			$data['valor'] = str_replace(",", ".", str_replace(".", "", $data['valor']));

			$data['encerrado'] = isset($data['encerrado']) ? 'S' : 'N';

			$registro->fill($data);
			$registro->save();

			\Session::flash('mensagem',['msg'=>$msg]);
			
			return redirect()->route('sedh.termo_administrativo');
		}
		catch(\Exception $e)
		{
			if($e->getCode() == 23505){
                $msg = 'Já existe um termo administrativo com os valores informados. Favor conferir os campos únicos.';
                \Session::flash('mensagem',['erro' => true, 'msg'=>$msg]);
            }else{
                $msg = str_replace("\n", "", $e->getMessage());
                \Session::flash('mensagem',['erro' => true, 'msg'=>$msg]);
            }
            return back()->withInput();
		}
	}

	public function excluir(Request $request)
	{
		try
		{	
			if(!auth()->user()->can('termo_administrativo_excluir')){
				return response()->json(
					[
						'status' => false,
						'mensagem' => 'Você não tem permissão para excluir esse registro.'
					], 200);
			}
			
			// Somente Números
			$id = preg_replace("/\D/","", $request->input('id'));

			$registro = TermoAdministrativo::find($id);

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
    //
}
