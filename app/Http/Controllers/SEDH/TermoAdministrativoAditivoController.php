<?php

namespace App\Http\Controllers\SEDH;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TermoAdministrativoAditivo;
use App\Models\vwTermoAdministrativoAditivo;
use App\Models\TipoTermoAdministrativo;

use Bouncer;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\SEDH\TermoAdministrativoAditivoRequest;

use App\Models\TermoAdministrativo;

class TermoAdministrativoAditivoController extends Controller
{
    public function index(Request $request)
	{
		try{
			if(!auth()->user()->can('termo_administrativo_aditivo_consultar')){
				\Session::flash('mensagem',['msg'=>'Você não tem permissão para listar esses registros.']);
				return redirect('/');
			}

			$lista = vwTermoAdministrativoAditivo::query();
			//dd($lista);

			// Total de Registros
			$qtd_registros = $lista->count();

			// Buscas e filtros
			$parametros = $request->all();
			//dd($parametros);


			if (isset($parametros['busca_desc_cod_tipo_termo_adm'])) {
				$desc = $parametros['busca_desc_cod_tipo_termo_adm'];
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


			if (isset($parametros['busca_desc_num_proximo'])) {
				$desc = $parametros['busca_desc_num_proximo'];
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

			$tipo_termo_adm = TipoTermoAdministrativo::orderBy('cod_tipo_termo_adm')->get();

			$lista = $lista->orderBy('id_termo_adm')->paginate(getenv('paginacao'))->appends($request->query());

			$titulo = "Principal";
			$subtitulo = "Termo Administrativo Aditivo";

			return view('sedh.termo_administrativo_aditivo.index', compact('lista', 'titulo', 'subtitulo','qtd_registros', 'parametros', 'tipo_termo_adm'));


		}catch(\Exception $e)
		{
			$msg = str_replace("\n", "", $e->getMessage());
			\Session::flash('mensagem',['erro' => true, 'msg'=>$msg]);

			return redirect('/');
		}
	}

	public function formulario($id = null, $uniqid = null, $cod_tipo_termo_adm = null, $dt_documento = null, $num_proximo = null, $id_termo_adm = null)
	{

		try{

			$registro = null;
			$subtitulo = "";

			if($id == 0){
				$id = null;
			}

			if($uniqid == 0){
				$uniqid = null;
			}

			//verifica se é uma operação de edição ou inserção e inicializa objeto
			if(isset($id))
			{
				// Somente Números
				$id = preg_replace("/\D/","", $id);

				$hab = 'termo_administrativo_aditivo_editar';
				$op = 'editar';
				$registro = TermoAdministrativoAditivo::find($id);
				$subtitulo = "Editar";
				$registro->cod_tipo_termo_adm = $cod_tipo_termo_adm;
				$registro->dt_documento = $dt_documento;
				$registro->num_proximo = $num_proximo;
				//dd($registro);

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
				$hab 	= 	'termo_administrativo_aditivo_adicionar';
				$op 	= 	'adicionar';
				$registro = new TermoAdministrativoAditivo();
				$subtitulo = "Adicionar";
				$registro->cod_tipo_termo_adm = $cod_tipo_termo_adm;
				$registro->dt_documento = $dt_documento;
				$registro->num_proximo = $num_proximo;
				$registro->id_termo_adm = $id_termo_adm;

				$registro->uniqid = '0';
			}
			//verifica permissão

			if(!auth()->user()->can($hab)){
				\Session::flash('mensagem',['msg'=>'Você não tem permissão para '.$op.' esse registro.']);
				return redirect('/');
			}
			
			//breadcrumb
			$titulo = "Termo Administrativo Aditivo";

			$tipo_termo_adm = TipoTermoAdministrativo::orderBy('cod_tipo_termo_adm')->get();


			//associações
			$perfis = Bouncer::role()->orderBy('name')->get();

			return view('sedh.termo_administrativo_aditivo.formulario', compact('registro','titulo','subtitulo','perfis', 'tipo_termo_adm'));

		}catch(\Exception $e)
		{
			$msg = str_replace("\n", "", $e->getMessage());
			\Session::flash('mensagem',['erro' => true, 'msg'=>$msg]);

			return redirect('/');
		}
	}

	public function salvar(TermoAdministrativoAditivoRequest $request)
	{
		try
		{
			$data = $request->all();

			if(isset($data['id_termo_adm_aditivo']))
			{

				// Somente Números
				$id = preg_replace("/\D/","", $data['id_termo_adm_aditivo']);

				$registro = TermoAdministrativoAditivo::find($id);
				$hab  =   'termo_administrativo_aditivo_editar';
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
				$registro = new TermoAdministrativoAditivo();

				$hab  =   'termo_administrativo_aditivo_adicionar';
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

			$data['dt_inicio_aditivo'] = implode('-',array_reverse(explode('/', $data['dt_inicio_aditivo'])));
			$data['dt_termino_aditivo'] = implode('-',array_reverse(explode('/', $data['dt_termino_aditivo'])));


			$data['vlr_reajuste'] = str_replace(",", ".", str_replace(".", "", $data['vlr_reajuste']));


			$registro->fill($data);
			//dd($registro);
			$registro->save();

			\Session::flash('mensagem',['msg'=>$msg]);
			
			return redirect()->route('sedh.termo_administrativo_aditivo');
		}
		catch(\Exception $e)
		{
			if($e->getCode() == 23505){
                $msg = 'Já existe um aditivo com os valores informados. Favor conferir os campos únicos.';
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
			if(!auth()->user()->can('termo_administrativo_aditivo_excluir')){
				return response()->json(
					[
						'status' => false,
						'mensagem' => 'Você não tem permissão para excluir esse registro.'
					], 200);
			}
			
			// Somente Números
			$id = preg_replace("/\D/","", $request->input('id'));

			$registro = TermoAdministrativoAditivo::find($id);

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
