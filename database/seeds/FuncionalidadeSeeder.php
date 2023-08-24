<?php

use Illuminate\Database\Seeder;
use App\Funcionalidade;

class FuncionalidadeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // FUNCIONALIDADES DO SISTEMA - FUNCIONALIDADES AGRUPAM HABILIDADES
        Funcionalidade::firstOrCreate(['nome_funcionalidade' => 'Cadastro de Usuário', 'desc_funcionalidade' => 'Esta funcionalidade permite a listagem, adição, edição e exclusão de usuários no sistema.', 'apelido' => 'usuario', 'model' => 'App\User' ]);

        Funcionalidade::firstOrCreate(['nome_funcionalidade' => 'Cadastro de Perfil', 'desc_funcionalidade' => 'Esta funcionalidade permite a listagem, adição, edição e exclusão de perfis no sistema.', 'apelido' => 'perfil', 'model' => 'Silber\Bouncer\Database\Ability' ]);

        Funcionalidade::firstOrCreate(['nome_funcionalidade' => 'Cadastro de Habilidade', 'desc_funcionalidade' => 'Esta funcionalidade permite a listagem, adição, edição e exclusão de habilidades no sistema.', 'apelido' => 'habilidade', 'model' => 'Silber\Bouncer\Database\Role' ]);

        Funcionalidade::firstOrCreate(['nome_funcionalidade' => 'Troca de Senha', 'desc_funcionalidade' => 'Esta funcionalidade permite ao usuário logado trocar sua senha.', 'apelido' => 'troca_senha', 'model' => 'App\User' ]);

        Funcionalidade::firstOrCreate(['nome_funcionalidade' => 'Relatório Usuário', 'desc_funcionalidade' => 'Esta funcionalidade permite visualizar e imprimir uma listagem com os usuários do sistema', 'apelido' => 'relatorio_usuario', 'model' => 'App\User' ]);

        Funcionalidade::firstOrCreate(['nome_funcionalidade' => 'Log Sistema', 'desc_funcionalidade' => 'Esta funcionalidade permite ao usuário visualizar as transações gravadas no Log', 'apelido' => 'log', 'model' => 'App\LogAtividades' ]);

        Funcionalidade::firstOrCreate(['nome_funcionalidade' => 'Página Inicial', 'desc_funcionalidade' => 'Esta funcionalidade permite ao usuário a visualização da Página Inicial do Sistema', 'apelido' => 'pagina_inicial']);

        Funcionalidade::firstOrCreate(['nome_funcionalidade' => 'Cadastro de Menu', 'desc_funcionalidade' => 'Esta funcionalidade permite a listagem, adição, edição e exclusão de menus no Sistema', 'apelido' => 'menu']);

        Funcionalidade::firstOrCreate(['nome_funcionalidade' => 'Cadastro de Funcionalidade', 'desc_funcionalidade' => 'Esta funcionalidade permite a listagem, adição, edição e exclusão de funcionalidades no Sistema', 'apelido' => 'funcionalidade']);

    }
}
