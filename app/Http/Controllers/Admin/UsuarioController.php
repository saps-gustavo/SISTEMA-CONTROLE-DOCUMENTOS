<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Bouncer;
use App\Http\Requests\UsuarioRequest;
use App\Http\Requests\TrocaSenhaRequest;
use App\User;
use App\GeraRelatorio;
use Illuminate\Support\Facades\DB;

class UsuarioController extends Controller
{
	public function index(Request $request)
	{
		if(!auth()->user()->can('usuario_listar')){
			\Session::flash('mensagem',['msg'=>'Você não tem permissão para listar usuários.']);
			return redirect('/');
		}

		$qtd_usuarios = User::all()->count();

		// Usuário 1 é o SYSTEM (utilizado para rotinas internas)
		$usuarios = User::select('usuario.*');

		//buscas e filtros
		$parametros = $request->all();

		//nome
		if(isset($parametros['busca_nome']))
		{
			$nome = $parametros['busca_nome'];
			//passagem numa função anônima para que as claúsulas sejam colocadas entre parenteses
			$usuarios = $usuarios->where(function($query) use($nome) {
				$query->where(\DB::raw('to_ascii(tb_usuario.nome_usuario)'),'ilike','%'.trocaAcento($nome).'%');
			});
		}

		//titulo
		if(isset($parametros['busca_email']))
		{
			$email = $parametros['busca_email'];
			//passagem numa função anônima para que as claúsulas sejam colocadas entre parenteses
			$usuarios = $usuarios->where(function($query) use($email) {
				$query->where(\DB::raw('to_ascii(tb_usuario.email)'),'ilike','%'.trocaAcento($email).'%');
			});
		}

		$usuarios = $usuarios->where("usuario.id_usuario", "<>", 1);
		$usuarios = $usuarios->orderBy('usuario.nome_usuario')->paginate(8);

		$titulo = "Principal";
		$subtitulo = "Usuários";
		return view('admin.usuario.index', compact('usuarios', 'titulo', 'subtitulo','qtd_usuarios'));
	}

	public function formulario($id = null, Request $request)
	{
		$data = $request->all();

		//verifica se é uma operação de edição ou inserção e inicializa objeto
		if(isset($id))
		{
			$hab 	= 	'usuario_editar';
			$op 	= 	'editar';
			$usuario = User::find($id);
			$subtitulo = "Editar Usuário ".$usuario->nome_usuario;
		}
		else
		{
			$hab 	= 	'usuario_adicionar';
			$op 	= 	'adicionar';
			$usuario = new User();
			$subtitulo = "Adicionar Novo Usuário";
		}
		//verifica permissão
		if(!auth()->user()->can($hab)){
			\Session::flash('mensagem',['msg'=>'Você não tem permissão para '.$op.' usuarios.']);
			return redirect('/');
		}
		//breadcrumb
		$titulo = "Usuários";
		
		//associações
		$perfis = Bouncer::role()->orderBy('name')->get();

		return view('admin.usuario.formulario', compact('usuario','titulo','subtitulo','perfis'));
	}

	public function salvar(UsuarioRequest $request)
	{
		$data = $request->all();

		$mensagem = \DB::transaction(function() use($data) {
			
			if(isset($data['id_usuario']))
			{
				$usuario = User::find($data['id_usuario']);
				$hab 	= 	'usuario_editar';
				$op 	= 	'editar';
			}
			else
			{
				$usuario = new User();
				$hab 	= 	'usuario_adicionar';
				$op 	= 	'adicionar';
			}
			if(!auth()->user()->can($hab))
			{
				DB::rollback();
				return 'Você não tem permissão para '.$op.' usuários.';
			}

			if(isset($usuario->entidade)){
				// Forma de evitar que se troque o código na URL
				DB::rollback();
				return 'Você não tem permissão para '.$op.' usuários que sejam entidades.';
			}

			if(isset($data['password'])){
				$usuario->password = bcrypt($data['password']);
			}
				
			$usuario->status = isset($data['status'])?1:0;
			$usuario->fill($data);
			$usuario->save();

			//associa os perfis selecionados
			if(isset($data['id_perfil']))
				Bouncer::sync($usuario)->roles($data['id_perfil']);
			else
				Bouncer::sync($usuario)->roles(null);

			return null;
		});

		if(isset($mensagem)){
			\Session::flash('mensagem',['erro' => true, 'msg'=> $mensagem]);
		}else{
			if(isset($data['id_usuario']))
			{
				$msg = "Registro alterado com sucesso!";
			}
			else
			{
				$msg = "Registro incluído com sucesso!";
			}
			\Session::flash('mensagem',['msg'=> $msg]);
		}

		return redirect()->route('admin.usuario');
	}
	public function excluir(Request $request)
	{
		try
		{
			if(!auth()->user()->can('usuario_excluir')){
				\Session::flash('mensagem',['msg'=>'Você não tem permissão para excluir usuarios.']);
				return redirect('/');
			}
			
			$id =  $request->input('id_usuario');
			
			\DB::transaction(function() use($id) {
				$usuario = User::find($id);
				$usuario->delete();
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

	public function trocaSenha()
	{
		$titulo = 'Principal';
		$subtitulo = 'Troca de Senha';
		$registro = auth()->user();
		return view('admin.usuario.troca_senha',compact ('titulo','subtitulo','registro'));
	}
	public function trocarSenha(TrocaSenhaRequest $request)
	{
		if(!auth()->user()->can('usuario_troca_senha')){
			\Session::flash('mensagem',['msg'=>'Você não tem permissão para trocar senha.']);
			return redirect('/');
		}
		$dados = $request->all();
		//recupera o usuário no banco de dados de acordo com o ID
		$usuario = User::find($dados['id_hidden']);
		//verifica se a senha antiga informada foi informada corretamente
		if(!\Hash::check($dados['password_old'], $usuario->password))
		{
		//interrompe a execução e cria um custom error para ser mostrado na view
			$bag = new MessageBag();
			$bag->add('senha_antiga_errada', 'A senha antiga informada não confere');
			return redirect()->back()->withInput($request->input())->with('errors', session()->get('errors', new ViewErrorBag)->put('default', $bag));
		}

		$dados['password_new'] = bcrypt($dados['password_new']);
		$usuario->password = $dados['password_new'];

		\DB::transaction(function() use($usuario) {
			$usuario->update();
		});

		\Session::flash('mensagem',['msg'=>'Senha alterada com sucesso!']);

		return redirect('/');
	}

	//função de apoio para redirecionar os logins expirados para a página de login nas requisições ajax
	public function testaLogin(Request $request)
	{
		return '';
	}

	public function relatorioUsuario()
	{
		if(!auth()->user()->can('relatorio_usuario')){
			\Session::flash('mensagem',['msg'=>'Você não tem permissão para imprimir este relatório.']);
			return redirect('/');
		}

		$nome_relatorio = 'Simple_Blue_1';
		$parametros = [];
		$gera_relatorio = new GeraRelatorio();
		$relatorio = $gera_relatorio->geraRelatorio($nome_relatorio,$parametros,'pdf');
	
		// retornamos o conteudo para o navegador que íra abrir o PDF
		return response($relatorio, 200)
		->header('Content-Type', 'application/pdf')
		->header('Content-Disposition', 'inline; filename="'.$nome_relatorio.'.pdf"');
	}

	public function habilidade($id = null)
	{
		if(!auth()->user()->can('usuario_associa_habilidade'))
		{
			\Session::flash('mensagem',['msg'=>'Você não tem permissão para associar habilidades ao usuário.']);
			return redirect('/');
		}

		$titulo = "Usuários";
		$subtitulo = "Adicionar Habilidades ao Usuário";
		$usuario = User::find($id);
		$funcionalidades = auth()->user()->listaFuncionalidades();

		return view('admin.usuario.habilidade', compact('usuario','titulo','subtitulo','funcionalidades'));

	}

	public function habilitar(Request $request, $id)
	{
		try
		{
			if(!auth()->user()->can('usuario_associa_habilidade'))
			{
				\Session::flash('mensagem',['msg'=>'Você não tem permissão para associar habilidades ao usuário.']);
				return redirect('/');
			}

			$data = $request->all();

			\DB::transaction(function() use($data, $id) {

				$usuario = User::find($id);

				$habilidades_usuario = auth()->user()->habilidadesPermitidas();
				$habilidades_usuario = $habilidades_usuario->unique('id')->pluck('id');

				$habilidades_marcadas = (isset($data['habilidade']) && count($data['habilidade']) > 0)?$data['habilidade']:[];
				$habilidades_negadas = (isset($data['habilidade-negada']) && count($data['habilidade-negada']) > 0)?$data['habilidade-negada']:[];

				if(count($habilidades_usuario) > 0)
				{
					foreach($habilidades_usuario as $hab)
					{
						$obj = Bouncer::ability()->findOrFail($hab);
						if(in_array($hab, $habilidades_marcadas)){
							Bouncer::allow($usuario)->to($obj->name);
						}
						else{
							Bouncer::disallow($usuario)->to($obj->name);
						}

						if(in_array($hab, $habilidades_negadas)){
							Bouncer::forbid($usuario)->to($obj->name);
						}
						else{
							Bouncer::unforbid($usuario)->to($obj->name);
						}
					}
				}
			});

			\Session::flash('mensagem',['msg'=>'Registro cadastrado com sucesso!']);
			return redirect()->route('admin.usuario');
		}
		catch(\Exception $e)
		{
			\Session::flash('mensagem',['msg'=>$e->getMessage()]);
			return redirect()->route('admin.usuario');
		}
	}
}
