<?php
namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\ImportarEMP;

class DeParaEMPLicitacaoTest extends TestCase
{

    // Depara simples 1 para 1
    public function testTipoLicitacaoCaso1()
    {
        $importarEMP = new ImportarEMP(2019);

        $tipoSIAFEM = 1;
        $vlrEmpenho = 10.58;
        $natureza = 339030;

        $this->assertEquals('2', $importarEMP->buscarDeParaDecorrenteLicitacao($tipoSIAFEM, $vlrEmpenho, $natureza));
    }

    // Depara baseado somente no valor <17600
    public function testTipoLicitacaoCaso2()
    {
        $importarEMP = new ImportarEMP(2019);

        $tipoSIAFEM = 5;
        $vlrEmpenho = 15934.02;
        $natureza = 339030; // indiferente

        $this->assertEquals('1', $importarEMP->buscarDeParaDecorrenteLicitacao($tipoSIAFEM, $vlrEmpenho, $natureza));
    }

    // valor e natureza não explícito na regra
    public function testTipoLicitacaoCaso3()
    {
        $importarEMP = new ImportarEMP(2019);

        $tipoSIAFEM = 5;
        $vlrEmpenho = 288085.86;
        $natureza = 449051;

        $this->assertEquals('3', $importarEMP->buscarDeParaDecorrenteLicitacao($tipoSIAFEM, $vlrEmpenho, $natureza));
    }

    // valor e natureza (caso natureza diferente)
    public function testTipoLicitacaoCaso4()
    {
        $importarEMP = new ImportarEMP(2019);

        $tipoSIAFEM = 5;
        $vlrEmpenho = 93341.64;
        $natureza = 339036;

        $this->assertEquals('3', $importarEMP->buscarDeParaDecorrenteLicitacao($tipoSIAFEM, $vlrEmpenho, $natureza));
    }

    // valor e natureza (caso natureza igual)
    public function testTipoLicitacaoCaso5()
    {
        $importarEMP = new ImportarEMP(2019);

        $tipoSIAFEM = 5;
        $vlrEmpenho = 26010.38;
        $natureza = 449051;

        $this->assertEquals('1', $importarEMP->buscarDeParaDecorrenteLicitacao($tipoSIAFEM, $vlrEmpenho, $natureza));
    }
}
