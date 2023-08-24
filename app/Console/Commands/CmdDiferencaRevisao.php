<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

/**
 * Comando que exibe os arquivos alterados entre a revisão informada e a HEAD.
 * Caso não seja informado uma revisão específica, será utilizada a revisão
 * do último deploy - definida em 'DEPLOY.txt'.
 */
class CmdDiferencaRevisao extends Command
{
	/* Indica o arquivo onde está o última revisão do deploy */
	const ARQUIVO_REVISAO_DEPLOY = 'DEPLOY.txt';

    protected $signature = 'deploy:diff {revisao='. self::ARQUIVO_REVISAO_DEPLOY .'}';
    protected $description = 'Exibe os arquivos alterados entre o HEAD e uma determinada revisão.';

    /**
     * Cria nova instância do comando.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execução do comando.
     *
     * @return mixed
     */
    public function handle()
    {
		$mat = [];
		$revisao = $this->obterRevisao();
		$saida = shell_exec("svn diff -r $revisao:HEAD --summarize");
		$linhas = explode("\n", $saida);

		foreach ($linhas as $item) {
			$linha = explode("       ", $item);
			$mat[] = $linha;
		}

		sort($mat);

		$this->exibirHeader($revisao);
		$this->table(['Status', 'Arquivo'], $mat);
	}
	
	/**
	 * Retorna a revisão alvo para o diff.
	 */
	private function obterRevisao() {
		$revisao = $this->argument('revisao');
		if($revisao == self::ARQUIVO_REVISAO_DEPLOY) {
			foreach(file(self::ARQUIVO_REVISAO_DEPLOY) as $line) {
				$revisao = $line;
			}
		}
		return $revisao;
	}

	private function exibirHeader($revisao) {
		$ultimaRev = exec('svn info -r HEAD --show-item revision');
		$this->info("#### Arquivos alterados entre as revisoes r$ultimaRev e $revisao ####");
	}
}
