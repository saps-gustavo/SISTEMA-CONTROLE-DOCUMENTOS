<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Arquivo;
use App\Layout;
use App\ArquivoDetalhamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Input;

/**
 * Rotas para o CRUD de Layout.
 */
class LayoutController extends Controller
{
	/**
	 * Rota para exibição da tela de Layout.
	 */
    public function index(Request $request)
    {
		if (!auth()->user()->can('layout_editar')) {
			\Session::flash('mensagem', ['msg'=>'Você não tem permissão para editar Layouts.']);
			return redirect('/');
		}

		$campos = null;
		$numero_detalhamento = null;
		$nome_arquivo = null;

		$ano = $request->input('ano');
		if( ! empty($ano) ) {
			$id_arquivo = $request->input('arquivo');
			$numero_detalhamento = $request->input('numero_detalhamento');
			$campos = ArquivoDetalhamento::obterCampos($ano, $id_arquivo, $numero_detalhamento);
			$nome_arquivo = Arquivo::find($id_arquivo)->nome_arquivo;
		}

		$titulo = "Principal";
		$subtitulo = "Layouts";

		$arquivos = Arquivo::all();

        return view('admin.layout.index', compact('titulo','subtitulo', 'arquivos', 'campos', 'ano', 'numero_detalhamento', 'nome_arquivo'));
    }

	/**
	 * Rota para salvar os dados de configuração de Layout.
	 */
    public function salvar(Request $request)
    {
		$ano = $request->input('ano');
		$arquivo = Arquivo::where('nome_arquivo', $request->input('nome_arquivo'))->first();
		$numero_detalhamento = $request->input('numero_detalhamento');

		$itensHabilitados['nome_campo'] = $request->input('campos');
		$itensHabilitados['posicao'] = $request->input('posicao');
		$itensHabilitados['tipo'] = $request->input('tipo');		

		$sucesso = Layout::atualizar($ano, $arquivo->id_arquivo, $numero_detalhamento, $itensHabilitados);

		$msg = $sucesso ? 'Layout atualizado com sucesso!' : 'Parâmetros inválidos! Contate o administrador.';

		\Session::flash('mensagem', [
			'msg' => $msg
		]);

        return back()->withInput();
	}

	/**
	 * Rota para obter o detalhamento a partir do Arquivo.
	 */
	public function obterDetalhamentoAjax(Request $request)
	{
		$id_arquivo = $request->input('arquivo');

        return response()->json([
            'status' => true,
            'detalhamentos' => ArquivoDetalhamento::porArquivo($id_arquivo)
        ], 200);
    }
}
