<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Funcionalidade;
use App\Menu;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\MenuRequest;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Response;


class MenuController extends Controller
{
    public function organizaMenu()
    {
    	if(!auth()->user()->can('menu_organizar'))
    	{
	      \Session::flash('mensagem',['msg'=>'Você não tem permissão para organizar Menus.']);
	      return redirect('/');
	    }


    	$titulo = "Principal";
    	$subtitulo = "Organiza Menu";

    	return view('admin.menu.organizaMenu', compact ('titulo', 'subtitulo'));
    }

    public function organizaMenuSalvar(Request $request)
    {
    	if(!auth()->user()->can('menu_organizar'))
    	{
	      \Session::flash('mensagem',['msg'=>'Você não tem permissão para organizar Menus.']);
	      return redirect('/');
	    }

    	try
    	{
	    	$data = $request->all();

	    	$json_menu = $data['nestable-output'];

	    	$array_json_menu = json_decode($json_menu);

	    	Menu::organizaMenuSalvar($array_json_menu, null, 0);

	    	return response()->json(
	                [
	                    'status' => true,
	                    'mensagem' => 'Menu Organizado com Sucesso'
	                ], 200);
        }
        catch(QueryException $e)
        {
            return response()->json(
              [
                'status' => false,
                'mensagem' => queryExceptionMessage($e),
            ], 200);
        }
        catch(\Exception $e)
        {
            return response()->json(
                [
                    'status' => false,
                    'mensagem' => $e->getMessage()
                ], 200);
        }
    }

    public function formularioModal(Request $request)
    {

        $id = Input::get('id');

        if(isset($id))
        {
            $op = "editar";
            $menu = Menu::find($id);
        }
        else
        {
            $op = "adicionar";
            $menu = new Menu();
        }
        //verifica permissao e retorna uma resposta em texto puro com codigo http de erro interno
        if(!auth()->user()->can('menu_'.$op))
        {
            return response('Você não tem permissão para realizar essa operação', 500)
            ->header('Content-Type', 'text/plain');
        }
        //associacoes
        $funcionalidades = Funcionalidade::orderBy('nome_funcionalidade')->get();
        $rotas = new \Illuminate\Support\Collection(Route::getRoutes()->get());
        $rotas->sortBy('uri');

        return view('admin.menu._includes.formularioModal',compact('menu','funcionalidades','rotas'));
    }

    public function salvarAjax(MenuRequest $request)
    {
        try
        {
            $data = $request->all();

            $id = $data['id_menu'];

            if(isset($id))
            {
                $op = "editar";
                $menu = Menu::find($id);
            }
            else
            {
                $op = "adicionar";
                $menu = new Menu();
            }

            if(!auth()->user()->can("menu_$op"))
            {
                return response()->json(
                    [
                        'status' => false,
                        'mensagem' => 'Você não tem permissão para '.$op.' menus'
                    ]);
            }

            $menu->fill($data);
            $menu->ordem_menu = Menu::getMaxOrdemMenu() + 1;
            $menu->save();

            return response()->json([
                'status' => true,
                'mensagem' => 'Operação '.$op.' em Menu realizada com sucesso'
            ]);

        }
        catch (\Exception $e)
        {
            return response()->json(
                [
                    'status' => false,
                    'mensagem' => $e->getMessage()
                ]);
        }
    }

    public function formularioModalExcluir(Request $request)
    {
        $id = Input::get('id');

        if(isset($id))
        {
            $op = "excluir";
            $menu = Menu::find($id);
        }
        else
        {
            //verifica permissao e retorna uma resposta em texto puro com codigo http de erro interno
            if(!auth()->user()->can('menu_'.$op))
            {
                return response('Parâmetros Incorretos', 500)
                ->header('Content-Type', 'text/plain');
            }
        }

        if(!auth()->user()->can('menu_'.$op))
        {
            //verifica permissao e retorna uma resposta em texto puro com codigo http de erro interno
            if(!auth()->user()->can('menu_'.$op))
            {
                return response('Você não tem permissão para realizar esta operação', 500)
                ->header('Content-Type', 'text/plain');
            }
        }

        return view('admin.menu._includes.excluirMenu',compact('menu'));

    }

    public function excluir(Request $request)
	{
		try
		{
			if(!auth()->user()->can('menu_excluir')){
                return response()->json(
    				[
    					'status' => false,
    					'mensagem' => 'Você não tem permissão para excluir menus'
    				], 500);
			}
			$id =  $request->input('id_menu');
			$menu = Menu::find($id);
			$menu->delete();

			return response()->json(
				[
					'status' => true,
					'mensagem' => 'Registro excluído com sucesso'
                ], 200);
                
            \Session::flash('mensagem',['msg'=>'Registro excluído com sucesso']);
		}
		catch(QueryException $e)
		{
			return response()->json(
				[
					'status' => false,
					'mensagem' => queryExceptionMessage($e),
				], 200);
		}
		catch(\Exception $e)
		{
			return response()->json(
				[
					'status' => false,
					'mensagem' => $e->getMessage()
				], 200);
		}
	}
}
