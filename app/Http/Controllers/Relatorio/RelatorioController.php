<?php

namespace App\Http\Controllers\Relatorio;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\vwRelatorioDoacao;
use App\Models\vwRelatorioFamilia;
use App\Models\Produto;

class RelatorioController extends Controller
{
	public function index(){

		if(!auth()->user()->can('relatorio_acessar')){
			\Session::flash('mensagem',['erro' => true, 'msg'=>'Você não tem permissão para listar esses registros.']);
			return redirect('/');
		}

		$titulo = "Principal";
		$subtitulo = "Relatórios";

		$produtos = Produto::orderBy('desc_produto')->get();

		return view('relatorio.index', compact('titulo', 'subtitulo','produtos'));
	}

	public function doacao($inicio = null, $fim = null){

		try{

			if(!auth()->user()->can('relatorio_acessar')){
				\Session::flash('mensagem',['msg'=>'Você não tem permissão para acessar esses registros.']);
				return redirect('/');
			}

			if(isset($inicio) && isset($fim)){
				$dados = vwRelatorioDoacao::whereBetween('data_lancamento', [$inicio, $fim])
						->orderBy('identificador')
						->orderBy('data_lancamento')
						->get();
			}else{
				$dados = vwRelatorioDoacao::orderBy('identificador')
										  ->orderBy('data_lancamento')
										  ->get();
			}

			$conteudoCSV = "identificador; doador; entidade; produto; qtd_doada; tipo_movimento; qtd_movimentada; origem;";
			$conteudoCSV .= "cpf_cnpj_origem; destino; cpf_cnpj_destino; bairro; data_historico; data_lancamento; data_movimento;\n";

			foreach($dados as $linha) {

				$conteudoCSV .= $linha['identificador'].";";
				$conteudoCSV .= $linha['doador'].";";
				$conteudoCSV .= $linha['entidade'].";";
				$conteudoCSV .= $linha['produto'].";";
				$conteudoCSV .= $linha['qtd_doada'].";";
				$conteudoCSV .= $linha['tipo_movimento'].";";
				$conteudoCSV .= $linha['qtd_movimento'].";";
				$conteudoCSV .= $linha['origem'].";";
				$conteudoCSV .= $linha['cpf_cnpj_origem'].";";
				$conteudoCSV .= $linha['destino'].";";
				$conteudoCSV .= $linha['cpf_cnpj_destino'].";";
				$conteudoCSV .= $linha['bairro'].";";
				$conteudoCSV .= $linha['data_historico'].";";
				$conteudoCSV .= $linha['data_lancamento'].";";
				$conteudoCSV .= $linha['data_movimento'].";";

				$conteudoCSV .= "\n";
			}

			$nomeArquivo = "relatorio_doacao.csv";

			return response($conteudoCSV)
				->header('Content-Type', 'application/csv')
				->header('Content-disposition',"attachment; filename=\"$nomeArquivo\"");

		}catch(\Exception $e)
		{
			$msg = str_replace("\n", "", $e->getMessage());
			\Session::flash('mensagem',['erro' => true, 'msg'=>$msg]);

			return redirect('/');
		}
	}

	public function familia($inicio = null, $fim = null){

		try{

			if(!auth()->user()->can('relatorio_acessar')){
				\Session::flash('mensagem',['msg'=>'Você não tem permissão para acessar esses registros.']);
				return redirect('/');
			}

			if(isset($inicio) && isset($fim)){
				$dados = vwRelatorioFamilia::whereBetween('data_cadastro', [$inicio, $fim])
						->orderBy('familia')
						->orderBy('familiar')
						->get();
			}else{
				$dados = vwRelatorioFamilia::orderBy('familia')
										   ->orderBy('familiar')
										   ->get();
			}

			$conteudoCSV = "familia; cpf_cnpj; rua; numero; complemento; cep; bairro; familiar; cpf; observacao; data_cadastro \n";

			foreach($dados as $linha) {

				$conteudoCSV .= $linha['familia'].";";
				$conteudoCSV .= $linha['cpf_cnpj'].";";
				$conteudoCSV .= $linha['rua'].";";
				$conteudoCSV .= $linha['numero'].";";
				$conteudoCSV .= $linha['complemento'].";";
				$conteudoCSV .= $linha['cep'].";";
				$conteudoCSV .= $linha['bairro'].";";
				$conteudoCSV .= $linha['familiar'].";";
				$conteudoCSV .= $linha['cpf'].";";
				$conteudoCSV .= $linha['observacao'].";";
				$conteudoCSV .= $linha['data_cadastro'].";";

				$conteudoCSV .= "\n";
			}

			$nomeArquivo = "relatorio_doacao.csv";

			return response($conteudoCSV)
				->header('Content-Type', 'application/csv')
				->header('Content-disposition',"attachment; filename=\"$nomeArquivo\"");

		}catch(\Exception $e)
		{
			$msg = str_replace("\n", "", $e->getMessage());
			\Session::flash('mensagem',['erro' => true, 'msg'=>$msg]);

			return redirect('/');
		}
	}

	public function produto($inicio = null, $fim = null){

		try{

			if(!auth()->user()->can('relatorio_acessar')){
				\Session::flash('mensagem',['msg'=>'Você não tem permissão para acessar esses registros.']);
				return redirect('/');
			}

			$condicao = "";

			if(isset($inicio) && isset($fim)){
				$condicao = " WHERE p.created_at BETWEEN '".$inicio."' AND '".$fim."'";
			}

			$strQuery = "SELECT p.desc_produto AS produto, u.desc_produto_unidade AS unidade, tp.desc_tipo_produto AS tipo,
						CASE WHEN p.kit = 1 THEN 'SIM' ELSE 'NÃO' END AS montar_kit,
						CASE WHEN p.formado = 1 THEN 'SIM' ELSE 'NÃO' END AS formado_por_kit,
						CASE WHEN p.exibe_estoque_uso_proprio = 1 THEN 'SIM' ELSE 'NÃO' END AS estoque_uso_proprio,
						p.created_at AS data_cadastro, p.updated_at AS data_ultima_atualizacao  
						FROM sch_radar.tb_produto p
						INNER JOIN sch_radar.tb_produto_unidade u ON u.id_produto_unidade = p.id_produto_unidade
						INNER JOIN sch_radar.tb_tipo_produto tp ON tp.id_tipo_produto = p.id_tipo_produto
						".$condicao."
						ORDER BY p.desc_produto";

			$dados = \DB::select($strQuery);

			$conteudoCSV = "produto; unidade; tipo; montar_kit; formado_por_kit; estoque_uso_proprio; data_cadastro; data_ultima_atualizacao;\n";

			foreach($dados as $linha) {

				$conteudoCSV .= $linha->produto.";";
				$conteudoCSV .= $linha->unidade.";";
				$conteudoCSV .= $linha->tipo.";";
				$conteudoCSV .= $linha->montar_kit.";";
				$conteudoCSV .= $linha->formado_por_kit.";";
				$conteudoCSV .= $linha->estoque_uso_proprio.";";
				$conteudoCSV .= $linha->data_cadastro.";";
				$conteudoCSV .= $linha->data_ultima_atualizacao.";";

				$conteudoCSV .= "\n";
			}

			$nomeArquivo = "relatorio_produto.csv";

			return response($conteudoCSV)
				->header('Content-Type', 'application/csv')
				->header('Content-disposition',"attachment; filename=\"$nomeArquivo\"");

		}catch(\Exception $e)
		{
			$msg = str_replace("\n", "", $e->getMessage());
			\Session::flash('mensagem',['erro' => true, 'msg'=>$msg]);

			return redirect('/');
		}
	}

	public function lancamento($inicio = null, $fim = null){

		try{

			if(!auth()->user()->can('relatorio_acessar')){
				\Session::flash('mensagem',['msg'=>'Você não tem permissão para acessar esses registros.']);
				return redirect('/');
			}

			$condicao = "";

			if(isset($inicio) && isset($fim)){
				$condicao = " WHERE le.created_at BETWEEN '".$inicio."' AND '".$fim."'";
			}

			$strQuery = "SELECT le.id_lancamento_estoque AS identificador, eo.desc_entidade AS origem,
								p.desc_produto AS produto, le.quantidade::INTEGER, e.desc_entidade AS destino, beo.desc_bairro AS bairro,
								tl.desc_tipo_lancamento AS tipo, ma.desc_motivo_avaria AS avaria,
								mr.desc_motivo_retencao AS retencao, le.created_at AS data_lancamento
						FROM sch_radar.tb_lancamento_estoque le
							INNER JOIN sch_radar.tb_entidade e ON e.id_entidade = le.id_entidade
							INNER JOIN sch_radar.tb_produto p ON p.id_produto = le.id_produto
							INNER JOIN sch_radar.tb_produto_unidade u ON u.id_produto_unidade = p.id_produto_unidade
							INNER JOIN sch_radar.tb_tipo_lancamento tl ON tl.id_tipo_lancamento = le.id_tipo_lancamento
							INNER JOIN sch_radar.tb_entidade eo ON eo.id_entidade = le.id_entidade_origem
							INNER JOIN sch_radar.tb_bairro beo ON beo.id_bairro = eo.id_bairro
							LEFT JOIN sch_radar.tb_motivo_avaria ma ON ma.id_motivo_avaria = le.id_motivo_avaria
							LEFT JOIN sch_radar.tb_motivo_retencao mr ON mr.id_motivo_retencao = le.id_motivo_retencao
						".$condicao."
						ORDER BY data_lancamento, origem, destino, produto";

			$dados = \DB::select($strQuery);

			$conteudoCSV = "identificador; origem; produto; quantidade; destino; bairro; tipo; avaria; retencao; data_lancamento;\n";

			foreach($dados as $linha) {

				$conteudoCSV .= $linha->identificador.";";
				$conteudoCSV .= $linha->origem.";";
				$conteudoCSV .= $linha->produto.";";
				$conteudoCSV .= $linha->quantidade.";";
				$conteudoCSV .= $linha->destino.";";
				$conteudoCSV .= $linha->bairro.";";
				$conteudoCSV .= $linha->tipo.";";
				$conteudoCSV .= $linha->avaria.";";
				$conteudoCSV .= $linha->retencao.";";
				$conteudoCSV .= $linha->data_lancamento.";";

				$conteudoCSV .= "\n";
			}

			$nomeArquivo = "relatorio_lancamento.csv";

			return response($conteudoCSV)
				->header('Content-Type', 'application/csv')
				->header('Content-disposition',"attachment; filename=\"$nomeArquivo\"");

		}catch(\Exception $e)
		{
			$msg = str_replace("\n", "", $e->getMessage());
			\Session::flash('mensagem',['erro' => true, 'msg'=>$msg]);

			return redirect('/');
		}
	}
	
}
