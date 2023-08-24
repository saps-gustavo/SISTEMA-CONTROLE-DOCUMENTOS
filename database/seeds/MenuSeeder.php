<?php

use Illuminate\Database\Seeder;
use App\Menu;
use App\Funcionalidade;

class MenuSeeder extends Seeder
{
    /**
    * Run the database seeds.
    *
    * @return void
    */
    public function run()
    {
		//******************************************************
		/*SEEDER DE MENUS - INSTRUÇÕES DE USO

        USE A INTERFACE GRÁFICA OU ESSE SEEDER PARA GERENCIAR MENUS, NUNCA OS DOIS JUNTOS,
        CASO A TABELA DE MENUS ESTEJA VAZIA PODE-SE USAR O SEEDER PARA CARREGAR OS MENUS E
        DEPOIS GERENCIÁ-LOS SÓ PELA INTERFACE GRÁFICA

		INSIRA OS MENUS NA ORDEM EM QUE QUER QUE ELES APAREÇAM, LEMBRANDO QUE AO PERTERCER
		A UM MENU PAI O NÚMERO INTEIRO DA COLUNA ORDEM_MENU SÓ VALERÁ PARA OS FILHOS.
		EXISTEM BASICAMENTE DOIS TIPOS DE MENU,RAIZ E CONTEÚDO:

		MENUS RAIZ - NÃO ESTÃO LIGADOS A FUNCIONALIDADE E NÃO POSSUEM LINK

		1-INSIRA O MENU UTILIZANDO A INSTRUÇÃO FIRST OR CREATE PASSANDO NO PRIMEIRO ARRAY O LABEL E A URL
		2-NO SEGUNDO ARRAY UTILIZE A FUNÇÃO ESTÁTICA GetMaxOrdemMenu E INCREMENTE UM PARA ASSOCIAR À ORDEM .

		MENUS CONTEÚDO - ESTÃO LIGADOS OU NÃO A UM MENU SUPERIOR E POSSUEM LINK E FUNCIONALIDADE

		1-SE O MENU POSSUIR UM MENU PAI RECUPERE O ID DO PAI NO BANCO
		2-RECUPERE A FUNCIONALIDADE ASSOCIADA NO BANCO CASO EXISTA
		3-INSIRA O MENU UTILIZANDO A INSTRUÇÃO FIRST OR CREATE PASSANDO NO PRIMEIRO ARRAY O LABEL E A URL
		4-NO SEGUNDO ARRAY UTILIZE A FUNÇÃO ESTÁTICA GetMaxOrdemMenu E INCREMENTE UM PARA ASSOCIAR À ORDEM_MENU
		5-AINDA NO SEGUNDO ARRAY COLOQUE O ID DA FUNCIONALIDADE E DO MENU SUPERIOR RECUPERADAS ANTERIORMENTE
		//*********************************************************
		*/
		$func_menu = Funcionalidade::where('apelido', 'pagina_inicial')->get()->first();

        Menu::firstOrCreate(
            [
            	'label_menu' => 'Página Inicial',
            	'url_menu' => 'index'
			],
            [
                'icone_menu' => 'home',
                'classe_menu' => 'collapsible-header waves-effect waves-teal',
                'ordem_menu' => Menu::getMaxOrdemMenu() + 1,
                'id_funcionalidade' => $func_menu->id_funcionalidade
            ]
        );

        Menu::firstOrCreate(
            [
            'label_menu' => 'Administrativo'],
            [
                'icone_menu' => 'settings',
                'classe_menu' => 'collapsible-header waves-effect waves-teal',
                'ordem_menu' => Menu::getMaxOrdemMenu() + 1,
            ]
        );
		$menu_adm = Menu::where('label_menu', 'Administrativo')->get()->first();
        $func_usuario = Funcionalidade::where('apelido', 'usuario')->get()->first();
        Menu::firstOrCreate(
            [
            'label_menu' => 'Usuários',
            'url_menu' => 'admin.usuario'],
            [
                'icone_menu' => 'person_add',
                'classe_menu' => 'collapsible-header waves-effect',
                'ordem_menu' => Menu::getMaxOrdemMenu() + 1,
                'id_menu_sup' => $menu_adm->id_menu,
                'id_funcionalidade' => $func_usuario->id_funcionalidade
            ]
        );

        $func_perfil = Funcionalidade::where('apelido', 'perfil')->get()->first();
        Menu::firstOrCreate(
            [

            'label_menu' => 'Perfis',
            'url_menu' => 'admin.perfil'],
            [
                'icone_menu' => 'assignment_turned_in',
                'classe_menu' => 'collapsible-header waves-effect',
                'ordem_menu' => Menu::getMaxOrdemMenu() + 1,
                'id_menu_sup' => $menu_adm->id_menu,
                'id_funcionalidade' => $func_perfil->id_funcionalidade
            ]
        );

        $func_funcionalidade = Funcionalidade::where('apelido', 'funcionalidade')->get()->first();
        Menu::firstOrCreate(
            [

            'label_menu' => 'Funcionalidade',
            'url_menu' => 'admin.funcionalidade'],
            [
                'icone_menu' => 'build',
                'classe_menu' => 'collapsible-header waves-effect',
                'ordem_menu' => Menu::getMaxOrdemMenu() + 1,
                'id_menu_sup' => $menu_adm->id_menu,
                'target_menu' => '_blank',
                'id_funcionalidade' => $func_funcionalidade->id_funcionalidade
            ]
        );

        $func_habilidade = Funcionalidade::where('apelido', 'habilidade')->get()->first();
        Menu::firstOrCreate(
            [

            'label_menu' => 'Habilidades',
            'url_menu' => 'admin.habilidade'],
            [
                'icone_menu' => 'assignment_ind',
                'classe_menu' => 'collapsible-header waves-effect',
                'ordem_menu' => Menu::getMaxOrdemMenu() + 1,
                'id_menu_sup' => $menu_adm->id_menu,
                'id_funcionalidade' => $func_habilidade->id_funcionalidade
            ]
        );

        $func_log = Funcionalidade::where('apelido', 'log')->get()->first();
        Menu::firstOrCreate(
            [
            'label_menu' => 'Log do Sistema',
            'url_menu' => 'admin.log'],
            [
                'icone_menu' => 'assignment',
                'classe_menu' => 'collapsible-header waves-effect',
                'ordem_menu' => Menu::getMaxOrdemMenu() + 1,
                'id_menu_sup' => $menu_adm->id_menu,
                'id_funcionalidade' => $func_log->id_funcionalidade
            ]
        );

        $func_trocar_senha = Funcionalidade::where('apelido', 'troca_senha')->get()->first();
        Menu::firstOrCreate(
            [
            'label_menu' => 'Trocar Senha',
            'url_menu' => 'admin.usuario.trocaSenha'],
            [
                'icone_menu' => 'repeat',
                'classe_menu' => 'collapsible-header waves-effect',
                'ordem_menu' => Menu::getMaxOrdemMenu() + 1,
                'id_menu_sup' => $menu_adm->id_menu,
                'id_funcionalidade' => $func_trocar_senha->id_funcionalidade
            ]
        );

        $func_menu = Funcionalidade::where('apelido', 'menu')->get()->first();
        Menu::firstOrCreate(
            [
            'label_menu' => 'Menu',
            'url_menu' => 'admin.menu.organizaMenu'],
            [
                'icone_menu' => 'clear_all',
                'classe_menu' => 'collapsible-header waves-effect',
                'ordem_menu' => Menu::getMaxOrdemMenu() + 1,
                'id_menu_sup' => $menu_adm->id_menu,
                'id_funcionalidade' => $func_menu->id_funcionalidade
            ]
        );


        Menu::firstOrCreate(
            [
            'label_menu' => 'Relatórios',
            'icone_menu' => 'content_paste'],
            [
                'classe_menu' => 'collapsible-header waves-effect waves-teal',
                'ordem_menu' => Menu::getMaxOrdemMenu() + 1,
            ]
        );
		$menu_sup_relatorio = Menu::where('label_menu','Relatórios')->get()->first();
        $func_rel_usuario = Funcionalidade::where('apelido', 'relatorio_usuario')->get()->first();
        Menu::firstOrCreate(
            [
            'label_menu' => 'Relatório de Usuário',
            'url_menu' => 'admin.usuario.relatorioUsuario'],
            [
                'icone_menu' => 'content_paste',
                'classe_menu' => 'collapsible-header waves-effect',
                'ordem_menu' => Menu::getMaxOrdemMenu() + 1,
                'id_menu_sup' => $menu_sup_relatorio->id_menu,
                'target_menu' => '_blank',
                'id_funcionalidade' => $func_rel_usuario->id_funcionalidade
            ]
        );
    }
}
