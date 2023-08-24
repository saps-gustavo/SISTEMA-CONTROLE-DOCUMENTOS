<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Bouncer;
use App\Http\Requests\PerfilRequest;
use App\Funcionalidade;
use App\User;
use PerfilSeeder;
use PerfilUsuarioSeeder;
use Illuminate\Support\Facades\DB;

class PerfilController extends Controller
{
	public function index(Request $request)
	{
		if(!auth()->user()->can('perfil_listar')){
			\Session::flash('mensagem',['msg'=>'Você não tem permissão para listar perfis.']);
			return redirect('/');
		}
		$qtd_perfis = Bouncer::role()->all()->count();
		$perfis = Bouncer::role();
		//buscas e filtros
		$parametros = $request->all();
		//nome
		if(isset($parametros['busca_nome']))
		{
			$nome = $parametros['busca_nome'];
			//passagem numa função anônima para que as claúsulas sejam colocadas entre parenteses
			$perfis = $perfis->where(function($query) use($nome) {
				$query->where(\DB::raw('to_ascii(name)'),'ilike','%'.trocaAcento($nome).'%');
			});
		}
		//cpf
		if(isset($parametros['busca_titulo']))
		{
			$titulo = $parametros['busca_titulo'];
			//passagem numa função anônima para que as claúsulas sejam colocadas entre parenteses
			$perfis = $perfis->where(function($query) use($titulo) {
				$query->where(\DB::raw('to_ascii(title)'),'ilike','%'.trocaAcento($titulo).'%');
			});
		}
		$perfis = $perfis->orderBy('name')->paginate(8);
		$titulo = "Principal";
		$subtitulo = "Perfis";

		$usuario_admin = new User();
		$usuario_admin = $usuario_admin->administrador();

		return view('admin.perfil.index', compact('perfis', 'titulo', 'subtitulo','qtd_perfis', 'usuario_admin'));
	}

	public function formulario($id = null, Request $request)
	{
		$data = $request->all();
		//verifica se é uma operação de edição ou inserção e inicializa objeto
		if(isset($id))
		{
			$hab  =   'perfil_editar';
			$op   =   'editar';
			$perfil = Bouncer::role()->find($id);
			$subtitulo = "Editar Perfil ".$perfil->name;
		}
		else
		{
			$hab  =   'perfil_adicionar';
			$op   =   'adicionar';
			$perfil = Bouncer::role();
			$subtitulo = "Adicionar Novo Perfil";
		}
		//verifica permissão
		if(!auth()->user()->can($hab)){
			\Session::flash('mensagem',['msg'=>'Você não tem permissão para '.$op.' perfis.']);
			return redirect('/');
		}
		//breadcrumb
		$titulo = "Perfis";
		return view('admin.perfil.formulario', compact('perfil','titulo','subtitulo'));
	}

	public function salvar(PerfilRequest $request)
	{
		try
		{
			$data = $request->all();
			
			if(isset($data['id']))
			{
				$perfil = Bouncer::role()->find($data['id']);
				$hab  =   'perfil_editar';
				$op   =   'editar';
				$msg = "Registro alterado com sucesso!";
			}
			else
			{
				$perfil = Bouncer::role();
				$hab  =   'perfil_adicionar';
				$op   =   'adicionar';
				$msg = "Registro incluído com sucesso!";
			}
			if(!auth()->user()->can($hab))
			{
				\Session::flash('mensagem',['msg'=>'Você não tem permissão para '.$op.' perfis.']);
				return redirect('/');
			}
			$perfil->fill($data);

			DB::transaction(function () use ($perfil) {
				$perfil->save();
			});

			\Session::flash('mensagem',['msg'=>$msg]);

			return redirect()->route('admin.perfil');
		}
		catch(QueryException $e)
		{
			$msg = queryExceptionMessage($e);
			\Session::flash('mensagem',['erro'=>true, 'msg'=>$msg]);

			return redirect()->route('admin.perfil');
		}
		catch(\Exception $e)
		{
			$msg = $e->getMessage();
			\Session::flash('mensagem',['erro'=>true, 'msg'=>$msg]);
			
			return redirect()->route('admin.perfil');
		}
	}

	public function excluir(Request $request)
	{
		try
		{
			if(!auth()->user()->can('perfil_excluir')){
				\Session::flash('mensagem',['msg'=>'Você não tem permissão para excluir perfis.']);
				return redirect('/');
			}

			$mensagem = DB::transaction(function () use ($request) {

				$id =  $request->input('id_perfil');

				$perfil_associado = DB::table("perfil_associado")->where('role_id', $id)->first();

				if(isset($perfil_associado)){
					DB::rollBack();
					return 'Esse perfil não pode ser excluído pois está associado a um ou mais usuários.';
				}

				$perfil = Bouncer::role()->find($id);
				$perfil->delete();

				return null;
			});

			if(isset($mensagem)){
				return response()->json(
					[
						'status' => false,
						'mensagem' => $mensagem,
					], 200);
			}else{
				return response()->json(
					[
						'status' => true,
						'mensagem' => 'Registro excluído com sucesso',
					], 200);
			}
	
		}
		catch(QueryException $e)
		{
			return response()->json(
				[
					'status' => false,
					'mensagem' => queryExceptionMessage($e),
				], 200);
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

	public function habilidade($id = null)
	{
		if(!auth()->user()->can('perfil_associa_habilidade'))
		{
			\Session::flash('mensagem',['msg'=>'Você não tem permissão para associar habilidades.']);
			return redirect('/');
		}

		$titulo = "Perfis";
		$subtitulo = "Associar Habilidades ao Perfil";

		$perfil = Bouncer::role()->find($id);
		//$funcionalidades =  Funcionalidade::funcionalidadesPorUsuario(auth()->user());
		$funcionalidades =  Funcionalidade::funcionalidadesTodas(auth()->user());

		return view('admin.perfil.habilidade', compact('perfil','titulo','subtitulo','funcionalidades'));
	}

	public function habilitar(Request $request, $id)
	{
		if(!auth()->user()->can('perfil_associa_habilidade'))
		{
			\Session::flash('mensagem',['msg'=>'Você não tem permissão para associar habilidades.']);
			return redirect('/');
		}
		try
		{
			$data = $request->all();
			$perfil = Bouncer::role()->find($id);

			//$habilidades_usuario = auth()->user()->habilidadesPermitidas();
			$habilidades_usuario = auth()->user()->TodasHabilidades();
			$habilidades_usuario = $habilidades_usuario->unique('id')->pluck('id');

			$habilidades_marcadas = (isset($data['habilidade']) && count($data['habilidade']) > 0)?$data['habilidade']:[];

			if(count($habilidades_usuario) > 0)
			{
				foreach($habilidades_usuario as $hab)
				{
					$obj = Bouncer::ability()->findOrFail($hab);
					if(in_array($hab, $habilidades_marcadas))
						Bouncer::allow($perfil)->to($obj->name);
					else
						Bouncer::disallow($perfil)->to($obj->name);
				}
			}
		}
		catch(\Exception $e)
		{
			\Session::flash('mensagem',['msg'=>$e->getMessage()]);
			return redirect()->route('admin.perfil');
		}
		\Session::flash('mensagem',['msg'=>'Registro cadastrado com sucesso!']);
		return redirect()->route('admin.perfil');
	}
}
