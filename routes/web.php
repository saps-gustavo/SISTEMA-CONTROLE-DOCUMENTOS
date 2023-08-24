<?php

Route::get('/', 'HomeController@index')->name('index');

Auth::routes();

Route::group(['middleware'=>'web'], function(){

	Route::get('/home', 'HomeController@index')->name('home');

	Route::get('/auth/password/email',['as'=>'auth.password.email', 'uses' => 'Auth\LoginController@enviaEmail']);

	/* CEP */
	Route::post('cep',['as' => 'cep.consultar','uses'=>'CEPController@consultar']);

});

Route::group(['middleware'=>'auth'], function(){


	Route::get('sedh/situacao_termo_adm',['as' => 'sedh.situacao_termo_adm','uses'=>'SEDH\SituacaoTermoAdmController@index']);

	Route::get('sedh/situacao_termo_adm/formulario/{id?}/{uniqid?}',['as' => 'sedh.situacao_termo_adm.formulario','uses'=>'SEDH\SituacaoTermoAdmController@formulario']);
	Route::post('sedh/situacao_termo_adm/salvar',['as' => 'sedh.situacao_termo_adm.salvar','uses'=>'SEDH\SituacaoTermoAdmController@salvar']);
	Route::post('sedh/situacao_termo_adm/excluir',['as' => 'sedh.situacao_termo_adm.excluir','uses'=>'SEDH\SituacaoTermoAdmController@excluir']);

	Route::get('sedh/tipo_servico',['as' => 'sedh.tipo_servico','uses'=>'SEDH\TipoServicoController@index']);

	Route::get('sedh/tipo_servico/formulario/{id?}/{uniqid?}',['as' => 'sedh.tipo_servico.formulario','uses'=>'SEDH\TipoServicoController@formulario']);
	Route::post('sedh/tipo_servico/salvar',['as' => 'sedh.tipo_servico.salvar','uses'=>'SEDH\TipoServicoController@salvar']);
	Route::post('sedh/tipo_servico/excluir',['as' => 'sedh.tipo_servico.excluir','uses'=>'SEDH\TipoServicoController@excluir']);

	Route::get('sedh/termo_administrativo',['as' => 'sedh.termo_administrativo','uses'=>'SEDH\TermoAdministrativoController@index']);

	Route::get('sedh/termo_administrativo/formulario/{id?}/{uniqid?}',['as' => 'sedh.termo_administrativo.formulario','uses'=>'SEDH\TermoAdministrativoController@formulario']);
	Route::post('sedh/termo_administrativo/salvar',['as' => 'sedh.termo_administrativo.salvar','uses'=>'SEDH\TermoAdministrativoController@salvar']);
	Route::post('sedh/termo_administrativo/excluir',['as' => 'sedh.termo_administrativo.excluir','uses'=>'SEDH\TermoAdministrativoController@excluir']);


	Route::get('sedh/tipo_termos_administrativos',['as' => 'sedh.tipo_termos_administrativos','uses'=>'SEDH\TipoTermosAdministrativosController@index']);

	Route::get('sedh/tipo_termos_administrativos/formulario/{id?}/{uniqid?}',['as' => 'sedh.tipo_termos_administrativos.formulario','uses'=>'SEDH\TipoTermosAdministrativosController@formulario']);
	Route::post('sedh/tipo_termos_administrativos/salvar',['as' => 'sedh.tipo_termos_administrativos.salvar','uses'=>'SEDH\TipoTermosAdministrativosController@salvar']);
	Route::post('sedh/tipo_termos_administrativos/excluir',['as' => 'sedh.tipo_termos_administrativos.excluir','uses'=>'SEDH\TipoTermosAdministrativosController@excluir']);


	Route::get('sedh/termo_administrativo_aditivo',['as' => 'sedh.termo_administrativo_aditivo','uses'=>'SEDH\TermoAdministrativoAditivoController@index']);

	Route::get('sedh/termo_administrativo_aditivo/formulario/{id?}/{uniqid?}/{cod_tipo?}/{dt_doc?}/{num_prox?}/{id_termo_adm?}',['as' => 'sedh.termo_administrativo_aditivo.formulario','uses'=>'SEDH\TermoAdministrativoAditivoController@formulario']);
	Route::post('sedh/termo_administrativo_aditivo/salvar',['as' => 'sedh.termo_administrativo_aditivo.salvar','uses'=>'SEDH\TermoAdministrativoAditivoController@salvar']);
	Route::post('sedh/termo_administrativo_aditivo/excluir',['as' => 'sedh.termo_administrativo_aditivo.excluir','uses'=>'SEDH\TermoAdministrativoAditivoController@excluir']);


	/*Rotas para Administrativo*/
	Route::get('admin/usuario/testaLogin',['as' => 'admin.usuario.testaLogin','uses'=>'Admin\UsuarioController@testaLogin']);
	Route::get('admin/usuario/trocaSenha',['as' => 'admin.usuario.trocaSenha', 'uses' => 'Admin\UsuarioController@trocaSenha']);
	Route::post('admin/usuario/trocarSenha',['as' => 'admin.usuario.trocarSenha', 'uses' => 'Admin\UsuarioController@trocarSenha']);
	Route::get('admin/usuario/relatorioUsuario',['as' => 'admin.usuario.relatorioUsuario', 'uses' => 'Admin\UsuarioController@relatorioUsuario']);

	/*Rotas para cadastro de habilidades*/
	Route::get('/admin/habilidade', ['as' => 'admin.habilidade', 'uses' => 'Admin\HabilidadeController@index']);
	Route::get('/admin/habilidade/formulario/{id?}',['as' => 'admin.habilidade.formulario', 'uses' => 'Admin\HabilidadeController@formulario']);
	Route::post('/admin/habilidade/excluir',['as'=>'admin.habilidade.excluir', 'uses'=>'Admin\HabilidadeController@excluir']);
	Route::post('/admin/habilidade/salvar', ['as' => 'admin.habilidade.salvar', 'uses' => 'Admin\HabilidadeController@salvar']);
	Route::post('/admin/habilidade/salvarAjax', ['as' => 'admin.habilidade.salvarAjax', 'uses' => 'Admin\HabilidadeController@salvarAjax']);
	Route::get('/admin/habilidade/ajaxSelectHabilidade',['as' => 'admin.habilidade.ajaxSelectHabilidade', 'uses' => 'Admin\HabilidadeController@ajaxSelectHabilidade']);

	/*Rotas para cadastro de usuario*/
	Route::get('/admin/usuario', ['as' => 'admin.usuario', 'uses' => 'Admin\UsuarioController@index']);
	Route::get('/admin/usuario/formulario/{id?}',['as' => 'admin.usuario.formulario', 'uses' => 'Admin\UsuarioController@formulario']);
	Route::post('/admin/usuario/excluir',['as'=>'admin.usuario.excluir', 'uses'=>'Admin\UsuarioController@excluir']);
	Route::post('/admin/usuario/salvar', ['as' => 'admin.usuario.salvar', 'uses' => 'Admin\UsuarioController@salvar']);
	Route::get('/admin/usuario/habilidade/{id?}', ['as' => 'admin.usuario.habilidade', 'uses' => 'Admin\UsuarioController@habilidade']);
	Route::post('/admin/usuario/habilitar/{id}', ['as' => 'admin.usuario.habilitar', 'uses' => 'Admin\UsuarioController@habilitar']);

	/*Rotas para cadastro de perfis*/
	Route::get('/admin/perfil', ['as' => 'admin.perfil', 'uses' => 'Admin\PerfilController@index']);
	Route::get('/admin/perfil/formulario/{id?}',['as' => 'admin.perfil.formulario', 'uses' => 'Admin\PerfilController@formulario']);
	Route::post('/admin/perfil/excluir',['as'=>'admin.perfil.excluir', 'uses'=>'Admin\PerfilController@excluir']);
	Route::post('/admin/perfil/salvar', ['as' => 'admin.perfil.salvar', 'uses' => 'Admin\PerfilController@salvar']);
	Route::get('/admin/perfil/habilidade/{id?}', ['as' => 'admin.perfil.habilidade', 'uses' => 'Admin\PerfilController@habilidade']);
	Route::post('/admin/perfil/habilitar/{id}', ['as' => 'admin.perfil.habilitar', 'uses' => 'Admin\PerfilController@habilitar']);

	/* Rotas para Menu */
	Route::get('/admin/menu/organizaMenu', ['as' => 'admin.menu.organizaMenu', 'uses' => 'Admin\MenuController@organizaMenu']);
	Route::post('/admin/menu/organizaMenu/salvar', ['as' => 'admin.menu.organizaMenu.salvar', 'uses' => 'Admin\MenuController@organizaMenuSalvar']);
	Route::get('/admin/menu/formularioModal',['as'=>'admin.menu.formularioModal', 'uses' => 'Admin\MenuController@formularioModal']);
	Route::post('/admin/menu/salvarAjax', ['as' => 'admin.menu.salvarAjax', 'uses' => 'Admin\MenuController@salvarAjax']);
	Route::get('/admin/menu/formularioModalExcluir',['as'=>'admin.menu.formularioModalExcluir', 'uses' => 'Admin\MenuController@formularioModalExcluir']);
	Route::post('/admin/menu/excluir',['as'=>'admin.menu.excluir', 'uses'=>'Admin\MenuController@excluir']);

	/*Rotas para cadastro de funcionalidades*/
	Route::get('/admin/funcionalidade', ['as' => 'admin.funcionalidade', 'uses' => 'Admin\FuncionalidadeController@index']);
	Route::post('/admin/funcionalidade/excluir',['as'=>'admin.funcionalidade.excluir', 'uses'=>'Admin\FuncionalidadeController@excluir']);
	Route::get('/admin/funcionalidade/formulario/{id?}',['as' => 'admin.funcionalidade.formulario', 'uses' => 'Admin\FuncionalidadeController@formulario']);
	Route::post('/admin/funcionalidade/salvar', ['as' => 'admin.funcionalidade.salvar', 'uses' => 'Admin\FuncionalidadeController@salvar']);
	Route::post('/admin/funcionalidade/associaHabilidade', ['as' => 'admin.funcionalidade.associaHabilidade', 'uses' => 'Admin\FuncionalidadeController@associaHabilidade']);
	Route::get('/admin/funcionalidade/carregaTabelaHabilidades',['as'=>'admin.funcionalidade.carregaTabelaHabilidades', 'uses' => 'Admin\FuncionalidadeController@carregaTabelaHabilidades']);

	/*Rotas para log do sistema*/
	Route::get('/admin/log', ['as' => 'admin.log', 'uses' => 'HomeController@logAtividade']);
	Route::get('adicionar-ao-log', 'HomeController@adicionaLog');
	Route::get('admin/log/detalhe/{id}', ['as' => 'admin.log.detalhe', 'uses' => 'HomeController@logDetalhe']);

});
