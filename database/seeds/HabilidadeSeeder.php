<?php

use Illuminate\Database\Seeder;
use App\Permissao;
use App\Funcionalidade;
//use Bouncer;

class HabilidadeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //CRIA HABILIDADES NO SISTEMA E ASSOCIA A UMA FUNCIONALIDADE EXISTENTE
        
        //usuario
        $func_usuario = Funcionalidade::where('apelido','usuario')->get()->first();

        Bouncer::ability()->firstOrCreate([
            'name' => 'usuario_listar',
            'title' => 'Lista Usuários',
            'id_funcionalidade' => $func_usuario->id_funcionalidade
        ]);

        Bouncer::ability()->firstOrCreate([
            'name' => 'usuario_adicionar',
            'title' => 'Adiciona Usuários',
            'id_funcionalidade' => $func_usuario->id_funcionalidade
        ]);

        Bouncer::ability()->firstOrCreate([
            'name' => 'usuario_editar',
            'title' => 'Editar Usuários',
            'id_funcionalidade' => $func_usuario->id_funcionalidade
        ]);

        Bouncer::ability()->firstOrCreate([
            'name' => 'usuario_excluir',
            'title' => 'Excluir Usuários',
            'id_funcionalidade' => $func_usuario->id_funcionalidade
        ]);

        Bouncer::ability()->firstOrCreate([
            'name' => 'usuario_associa_habilidade',
            'title' => 'Associa Habilidade aos Usuários',
            'id_funcionalidade' => $func_usuario->id_funcionalidade
        ]);

        //perfil
        $func_perfil = Funcionalidade::where('apelido','perfil')->get()->first();

        Bouncer::ability()->firstOrCreate([
            'name' => 'perfil_listar',
            'title' => 'Lista Perfis',
            'id_funcionalidade' => $func_perfil->id_funcionalidade
        ]);

        Bouncer::ability()->firstOrCreate([
            'name' => 'perfil_adicionar',
            'title' => 'Adiciona Perfis',
            'id_funcionalidade' => $func_perfil->id_funcionalidade
        ]);

        Bouncer::ability()->firstOrCreate([
            'name' => 'perfil_editar',
            'title' => 'Editar Perfis',
            'id_funcionalidade' => $func_perfil->id_funcionalidade
        ]);

        Bouncer::ability()->firstOrCreate([
            'name' => 'perfil_excluir',
            'title' => 'Excluir Perfis',
            'id_funcionalidade' => $func_perfil->id_funcionalidade
        ]);

        Bouncer::ability()->firstOrCreate([
            'name' => 'perfil_associa_habilidade',
            'title' => 'Associa Habilidade aos Perfis',
            'id_funcionalidade' => $func_perfil->id_funcionalidade
        ]);

        //habilidade
        $func_habilidade = Funcionalidade::where('apelido','habilidade')->get()->first();

        Bouncer::ability()->firstOrCreate([
            'name' => 'habilidade_listar',
            'title' => 'Lista Habilidades',
            'id_funcionalidade' => $func_habilidade->id_funcionalidade
        ]);

        Bouncer::ability()->firstOrCreate([
            'name' => 'habilidade_adicionar',
            'title' => 'Adiciona Habilidades',
            'id_funcionalidade' => $func_habilidade->id_funcionalidade
        ]);

        Bouncer::ability()->firstOrCreate([
            'name' => 'habilidade_editar',
            'title' => 'Editar Habilidades',
            'id_funcionalidade' => $func_habilidade->id_funcionalidade
        ]);

        Bouncer::ability()->firstOrCreate([
            'name' => 'habilidade_excluir',
            'title' => 'Excluir Habilidades',
            'id_funcionalidade' => $func_habilidade->id_funcionalidade
        ]);

        //habilidade
        $func_funcionalidade = Funcionalidade::where('apelido','funcionalidade')->get()->first();

        Bouncer::ability()->firstOrCreate([
            'name' => 'funcionalidade_listar',
            'title' => 'Lista Funcionalidades',
            'id_funcionalidade' => $func_funcionalidade->id_funcionalidade
        ]);

        Bouncer::ability()->firstOrCreate([
            'name' => 'funcionalidade_adicionar',
            'title' => 'Adiciona Funcionalidades',
            'id_funcionalidade' => $func_funcionalidade->id_funcionalidade
        ]);

        Bouncer::ability()->firstOrCreate([
            'name' => 'funcionalidade_editar',
            'title' => 'Editar Funcionalidades',
            'id_funcionalidade' => $func_funcionalidade->id_funcionalidade
        ]);
        Bouncer::ability()->firstOrCreate([
            'name' => 'funcionalidade_excluir',
            'title' => 'Excluir Funcionalidades',
            'id_funcionalidade' => $func_funcionalidade->id_funcionalidade
        ]);

        //troca_senha
        $func_troca_senha = Funcionalidade::where('apelido','troca_senha')->get()->first();

        Bouncer::ability()->firstOrCreate(['name' => 'usuario_troca_senha', 'title' => 'Troca Senha', 'id_funcionalidade' => $func_troca_senha->id_funcionalidade]);

        //relatorio usuario
        $func_relatorio_usuario = Funcionalidade::where('apelido','relatorio_usuario')->get()->first();
        //relatorio usuario
        Bouncer::ability()->firstOrCreate(['name' => 'relatorio_usuario', 'title' => 'Relatório de Usuário', 'id_funcionalidade' => $func_relatorio_usuario->id_funcionalidade]);

        //log sistema
        $func_log_sistema = Funcionalidade::where('apelido','log')->get()->first();
        //relatorio usuario
        Bouncer::ability()->firstOrCreate(['name' => 'log_sistema', 'title' => 'Log do Sistema', 'id_funcionalidade' => $func_log_sistema->id_funcionalidade]);

        //habilidade
        $func_menu = Funcionalidade::where('apelido','menu')->get()->first();

        Bouncer::ability()->firstOrCreate([
            'name' => 'menu_listar',
            'title' => 'Lista Menus',
            'id_funcionalidade' => $func_menu->id_funcionalidade
        ]);

        Bouncer::ability()->firstOrCreate([
            'name' => 'menu_adicionar',
            'title' => 'Adiciona Menus',
            'id_funcionalidade' => $func_menu->id_funcionalidade
        ]);

        Bouncer::ability()->firstOrCreate([
            'name' => 'menu_editar',
            'title' => 'Editar Menus',
            'id_funcionalidade' => $func_menu->id_funcionalidade
        ]);

        Bouncer::ability()->firstOrCreate([
            'name' => 'menu_excluir',
            'title' => 'Excluir Menus',
            'id_funcionalidade' => $func_menu->id_funcionalidade
        ]);

        Bouncer::ability()->firstOrCreate([
            'name' => 'menu_organizar',
            'title' => 'Organizar Menus',
            'id_funcionalidade' => $func_menu->id_funcionalidade
        ]);

        //troca_senha
        $func_pagina_inicial = Funcionalidade::where('apelido','pagina_inicial')->get()->first();

        Bouncer::ability()->firstOrCreate(['name' => 'pagina_inicial', 'title' => 'Página Inicial', 'id_funcionalidade' => $func_pagina_inicial->id_funcionalidade]);

    }
}
