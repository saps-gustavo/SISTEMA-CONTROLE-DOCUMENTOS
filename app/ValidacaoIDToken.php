<?php

namespace App;

use App\Models\Bairro;

use App\Models\Entidade;
use App\Models\ProdutoEntidade;
use App\Models\MotivoAvaria;
use App\Models\MotivoRetencao;
use App\Models\LancamentoEstoque;
use App\Models\TipoLancamento;
use App\Models\ProdutoEntidadeEstoque;
use App\Models\SolicitarDoacao;

class ValidacaoIDToken
{

    // Valida se a Entidade existe e se o uniqid é o correto
    public function ValidaTokenIdEntidade($id_entidade, $uniqid){

        try{

            $entidade = Entidade::find($id_entidade);

            // Verifica se existe o registro
            if(!isset($entidade)){
                return [
                        'status' => false,
                        'mensagem' => 'Registro (entidade) não encontrado.',
                        'registro' => null
                    ];
            }

            // Verifica se o uniqid do registro é igual ao passado
            if($uniqid != $entidade->uniqid){
                return [
                    'status' => false,
                    'mensagem' => 'Permissão negada (entidade).',
                    'registro' => null
                ];
            }

            return [
                'status' => true,
                'mensagem' => '',
                'registro' => $entidade
            ];

        }catch(\Exception $e){
            return [
                'status' => false,
                'mensagem' => $e->getMessage(),
                'registro' => null
            ];
        }
    }

    // Valida se a Produto Entidade existe e se o uniqid é o correto
    public function ValidaTokenIdProdutoEntidade($id_produto_entidade, $uniqid){

        try{

            $produto_entidade = ProdutoEntidade::find($id_produto_entidade);

            // Verifica se existe o registro
            if(!isset($produto_entidade)){
                return [
                    'status' => false,
                    'mensagem' => 'Registro (produto entidade) não encontrado.',
                    'registro' => null
                ];
            }

            // Verifica se o uniqid do registro é igual ao passado
            if($uniqid != $produto_entidade->uniqid){
                return [
                    'status' => false,
                    'mensagem' => 'Permissão negada (produto entidade).',
                    'registro' => null
                ];
            }

            return [
                'status' => true,
                'mensagem' => '',
                'registro' => $produto_entidade
            ];

        }catch(\Exception $e){
            return [
                'status' => false,
                'mensagem' => $e->getMessage(),
                'registro' => null
            ];
        }
    }

    // Valida se a Produto Entidade Estoque existe e se o uniqid é o correto
    public function ValidaTokenIdProdutoEntidadeEstoque($id_produto_entidade_estoque, $uniqid, $verifica_estoque = false){

        try{

            $produto_entidade_estoque = ProdutoEntidadeEstoque::find($id_produto_entidade_estoque);

            // Verifica se existe o registro
            if(!isset($produto_entidade_estoque)){
                return [
                    'status' => false,
                    'mensagem' => 'Registro (produto entidade estoque) não encontrado.',
                    'registro' => null
                ];
            }

            // Verifica se o uniqid do registro é igual ao passado
            if($uniqid != $produto_entidade_estoque->uniqid){
                return [
                    'status' => false,
                    'mensagem' => 'Permissão negada (produto entidade estoque).',
                    'registro' => null
                ];
            }

            if($verifica_estoque == true && $produto_entidade_estoque->status == 0){
                return [
                    'status' => false,
                    'mensagem' => 'O estoque (produto entidade estoque) do item foi alterado. Favor verificar.',
                    'registro' => null
                ];
            }

            return [
                'status' => true,
                'mensagem' => '',
                'registro' => $produto_entidade_estoque
            ];

        }catch(\Exception $e){
            return [
                'status' => false,
                'mensagem' => $e->getMessage(),
                'registro' => null
            ];
        }
    }

    // Valida se o Motivo Avaria existe e se o uniqid é o correto
    public function ValidaTokenIdMotivoAvaria($id_motivo_avaria, $uniqid){

        try{

            $motivo_avaria = MotivoAvaria::find($id_motivo_avaria);

			// Verifica se existe o registro
			if(!isset($motivo_avaria)){
				return [
                    'status' => false,
                    'mensagem' => 'Registro (motivo avaria) não encontrado.',
                    'registro' => null
                ];
			}

			// Verifica se o uniqid do registro é igual ao passado
			if($uniqid != $motivo_avaria->uniqid){
				return [
                    'status' => false,
                    'mensagem' => 'Permissão negada (motivo avaria).',
                    'registro' => null
                ];
			}

            return [
                'status' => true,
                'mensagem' => '',
                'registro' => $motivo_avaria
            ];

        }catch(\Exception $e){
            return [
                'status' => false,
                'mensagem' => $e->getMessage(),
                'registro' => null
            ];
        }
    }

    // Valida se o Motivo Retenção existe e se o uniqid é o correto
    public function ValidaTokenIdMotivoRetencao($id_motivo_retencao, $uniqid){

        try{

            $motivo_retencao = MotivoRetencao::find($id_motivo_retencao);

			// Verifica se existe o registro
			if(!isset($motivo_retencao)){
				return [
                    'status' => false,
                    'mensagem' => 'Registro (motivo retenção) não encontrado.',
                    'registro' => null
                ];
			}

			// Verifica se o uniqid do registro é igual ao passado
			if($uniqid != $motivo_retencao->uniqid){
				return [
                    'status' => false,
                    'mensagem' => 'Permissão negada (motivo retenção).',
                    'registro' => null
                ];
			}

            return [
                'status' => true,
                'mensagem' => '',
                'registro' => $motivo_retencao
            ];

        }catch(\Exception $e){
            return [
                'status' => false,
                'mensagem' => $e->getMessage(),
                'registro' => null
            ];
        }
    }

    // Valida se o Lançamento de Estoque existe e se o uniqid é o correto
    public function ValidaTokenIdLancamento($id_lancamento_estoque, $uniqid){

        try{

            $lancamento = LancamentoEstoque::find($id_lancamento_estoque);

			// Verifica se existe o registro
			if(!isset($lancamento)){
				return [
                    'status' => false,
                    'mensagem' => 'Registro (lançamento) não encontrado.',
                    'registro' => null
                ];
			}

            // Verifica se o uniqid do registro é igual ao passado
			if($uniqid != $lancamento->uniqid){
				return [
                    'status' => false,
                    'mensagem' => 'Permissão negada (lançamento).',
                    'registro' => null
                ];
			}

            return [
                'status' => true,
                'mensagem' => '',
                'registro' => $lancamento
            ];

        }catch(\Exception $e){
            return [
                'status' => false,
                'mensagem' => $e->getMessage(),
                'registro' => null
            ];
        }
    }

    // Valida se o Bairro existe e se o uniqid é o correto
    public function ValidaTokenIdBairro($id_bairro, $uniqid){

        try{

            $bairro = Bairro::find($id_bairro);

			// Verifica se existe o registro
			if(!isset($bairro)){
				return [
                    'status' => false,
                    'mensagem' => 'Registro (bairro) não encontrado.',
                    'registro' => null
                ];
			}

            // Verifica se o uniqid do registro é igual ao passado
			if($uniqid != $bairro->uniqid){
				return [
                    'status' => false,
                    'mensagem' => 'Permissão negada (bairro).',
                    'registro' => null
                ];
			}

            return [
                'status' => true,
                'mensagem' => '',
                'registro' => $bairro
            ];

        }catch(\Exception $e){
            return [
                'status' => false,
                'mensagem' => $e->getMessage(),
                'registro' => null
            ];
        }
    }

    // Valida se o Tipo de Lançamento existe e se o uniqid é o correto
    public function ValidaTokenIdTipoLancamento($id_tipo_lancamento, $uniqid){
        try{

            $tipo = TipoLancamento::find($id_tipo_lancamento);

			// Verifica se existe o registro
			if(!isset($tipo)){
				return [
                    'status' => false,
                    'mensagem' => 'Registro (tipo lançamento) não encontrado.',
                    'registro' => null
                ];
			}

            // Verifica se o uniqid do registro é igual ao passado
			if($uniqid != $tipo->uniqid){
				return [
                    'status' => false,
                    'mensagem' => 'Permissão negada (tipo lançamento).',
                    'registro' => null
                ];
			}

            return [
                'status' => true,
                'mensagem' => '',
                'registro' => $tipo
            ];

        }catch(\Exception $e){
            return [
                'status' => false,
                'mensagem' => $e->getMessage(),
                'registro' => null
            ];
        }
    }

    // Valida se s Solicitação de Doação existe e se o uniqid é o correto
    public function ValidaTokenIdSolicitacaoDoacao($id_solicitar_doacao, $uniqid){
        try{

            $solicitacao_doacao = SolicitarDoacao::find($id_solicitar_doacao);

			// Verifica se existe o registro
			if(!isset($solicitacao_doacao)){
				return [
                    'status' => false,
                    'mensagem' => 'Registro (solicitação doação) não encontrado.',
                    'registro' => null
                ];
			}

            // Verifica se o uniqid do registro é igual ao passado
			if($uniqid != $solicitacao_doacao->uniqid){
				return [
                    'status' => false,
                    'mensagem' => 'Permissão negada (solicitação doação).',
                    'registro' => null
                ];
			}

            return [
                'status' => true,
                'mensagem' => '',
                'registro' => $solicitacao_doacao
            ];

        }catch(\Exception $e){
            return [
                'status' => false,
                'mensagem' => $e->getMessage(),
                'registro' => null
            ];
        }
    }
}
