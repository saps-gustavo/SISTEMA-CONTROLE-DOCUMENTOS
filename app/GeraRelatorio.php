<?php

namespace App;

use Illuminate\Http\Request;
use PHPJasper\PHPJasper;
use App\Http\Controllers\ReportController;

class GeraRelatorio
{
    public function getDatabaseConfig()
    {
        return [
            'driver' => 'postgres',
            'username' => env('DB_USERNAME','adm_saps'),
            'password' => env('DB_PASSWORD','vErygRn?'),
            'host'     => env('DB_HOST','172.20.23.192'),
            'database' => env('DB_DATABASE','pr_saps'),
            'port'     => env('DB_PORT','65432'),
            //'jdbc_dir' => base_path() . env('JDBC_DIR', '/vendor/lavela/phpjasper/src/JasperStarter/jdbc'),
            //'jdbc_dir' => base_path().'/vendor/geekcom/phpjasper-laravel/bin/jasperstarter/jdbc',
        ];
    }

    public function geraRelatorio($relatorio, $parametros = [], $saida = 'pdf')
    {
        if(!isset($relatorio))
            throw new \Exception('Relatório não informado');

        $parametros['path_report'] = pathReport();

        // coloca na variavel o caminho do novo relatório que será gerado
        $output = public_path() . '/reports/' . time() . $relatorio;
        // instancia um novo objeto JasperPHP

        $report = new PHPJasper;
        // chama o método que irá gerar o relatório
        // passamos por parametro:
        // o arquivo do relatório com seu caminho completo
        // o nome do arquivo que será gerado
        // o tipo de saída
        // parametros ( nesse caso não tem nenhum)

        //dd($this->getDatabaseConfig());

        $options = [
            'format' => [$saida],
            'locale' => 'pt_BR',
            'params' => $parametros,
            'db_connection' => $this->getDatabaseConfig()
        ];

        $report->process(
            resource_path() . '/relatorios/'.$relatorio.'.jrxml',
            $output,
            $options
        )->execute();
        
        $file = $output . '.' .$saida;
        $path = $file;

        // caso o arquivo não tenha sido gerado retorno um erro 404
        if (!file_exists($file)) {
            throw new \Exception('Erro na criação do relatório.');
        }
        
        //caso tenha sido gerado pego o conteudo
        $file = file_get_contents($file);

        unlink($path);

        return $file;

    }
}
