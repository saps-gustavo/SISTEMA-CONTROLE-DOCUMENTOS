<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\ImportarSIAFEM;
use Illuminate\Support\Facades\Log;

class CmdImportarSIAFEM extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'importar:siafem';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importar dados CSV SIAFEM para PGSQL';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Log::info('Importando dados!');
        $importar = new ImportarSIAFEM();
        $importar->importar();
        Log::info('Dados importados!');
    }

}
