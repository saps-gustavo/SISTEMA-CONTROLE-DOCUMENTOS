<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Menu;
use Illuminate\Support\Collection;

//variável global a ser utilizada na função recursiva organizaMenuSalvar
$ordemMenuTeste;

class Menu extends Model
{
	protected $table = 'menu';

	protected $primaryKey = 'id_menu';

	protected $fillable = [
        'id_funcionalidade',
		'id_menu_sup',
        'label_menu',
        'url_menu',
        'icone_menu',
        'classe_menu',
        'updated_at',
        'created_at',
        'ordem_menu',
        'target_menu'
	];

	public static $ordemMenu;

	public function menuSup()
	{
		return $this->belongsTo('App\Menu','id_menu_sup');
	}

	public function filhos()
	{
	    return $this->hasMany('App\Menu', 'id_menu_sup');
	}

	public function funcionalidade()
	{
		return $this->belongsTo('App\Funcionalidade','id_funcionalidade');
	}

	//funcao recursiva que retorna o menu na ordem do banco de dados
	public static function arvoreMenu($id_menu_sup)
	{
		//inicializa collection e query
		$colecao_item = new Collection();
		$items = Menu::query();

		//filtra pelo parametro recursivamente
		if(isset($id_menu_sup))
			$items = $items->where('id_menu_sup', $id_menu_sup);

		//pega habilidades do usuario
		$funcionalidades_permitidas = auth()->user()->habilidadesPermitidas()->where('id_funcionalidade', '!=', NULL)->unique('id_funcionalidade')->pluck('id_funcionalidade','id_funcionalidade');

		//se estão setadas funcionalidades, filtra caso contrário não retorna nada
		if(isset($funcionalidades_permitidas) && $funcionalidades_permitidas->count() > 0)
		{
			$items = $items->where(function($q) use($funcionalidades_permitidas){
				$q = $q->whereNull('id_funcionalidade')->orWhereIn('id_funcionalidade', $funcionalidades_permitidas);
			});
		}
		else
		{
			$items =  Menu::query();
			return new Collection();
		}
		//ordenação
		$items = $items->orderBy('ordem_menu')->get();

		//filtra pela funcionalidade dos filhos
		$menus_permitidos = $items->unique('id_menu')->pluck('id_menu');

		$items = $items->filter(function ($item) use($menus_permitidos) {
    		return $item->id_funcionalidade != null || ($item->id_funcionalidade == null && ($item->filhos()->get()->count() <= 0 || $item->filhos()->get()->whereIn('id_menu', $menus_permitidos)->count() > 0));
		});

		//percorre os itens já filtrados
		foreach($items as $item)
		{
			//chama a função recursivamente para inserir os filhos como um atributo do tipo collection dentro do model menu
			if($item->id_menu_sup == $id_menu_sup)
		    {
				$colecao_item->push($item);
		        $item->filhos = Menu::arvoreMenu($item->id_menu);
		    }
		}

		//se a coleção tem registros, retorna
		if(isset($colecao_item) && $colecao_item->count() > 0)
		{
			return $colecao_item;
		}


	}

	public static function imprimeArvoreMenu()
	{
		$arvoreMenu = Menu::arvoreMenu(null);

		foreach($arvoreMenu as $menu)
		{
			echo $menu->label_menu."\n";

			$filhos = $menu->filhos;
			$espaco = "   ";
			while(isset($filhos) && $filhos->count() > 0)
			{
				$espaco = $espaco.$espaco;
				foreach($filhos as $filho)
				{
					echo $espaco.$filho->label_menu."\n";
					$filhos = $filho->filhos;

				}
			}
		}
	}

	public static function testeMenu()
	{
		//testa se o usuário tem permissão em todas as habilidades
		if(!User::find(13)->getAbilities()->contains('name','*'))
			//pega habilidades do usuario
			$funcionalidades_permitidas = User::find(13)->getAbilities()->where('id_funcionalidade', '!=', NULL)->unique('id_funcionalidade')->pluck('id_funcionalidade','id_funcionalidade');

		//inicializa collection
		$colecao_item = new Collection();
		$items = Menu::query();
		//$items = Menu::leftJoin('funcionalidade','funcionalidade.id_funcionalidade','=','menu.id_funcionalidade');

		if(isset($id_menu_sup))
			$items = $items->where('id_menu_sup', $id_menu_sup);

		if(isset($funcionalidades_permitidas) and $funcionalidades_permitidas->count() > 0)
		{
			$items = $items->where(function($q) use($funcionalidades_permitidas){
				$q = $q->whereNull('id_funcionalidade')->orWhereIn('id_funcionalidade', $funcionalidades_permitidas);
			});
		}

		$items = $items->orderBy('ordem_menu')->get();

		$menus_permitidos = $items->unique('id_menu')->pluck('id_menu');

		$filtered = $items->filter(function ($item) use($menus_permitidos) {
    		return $item->id_funcionalidade != null || ($item->id_funcionalidade == null && ($item->filhos()->get()->count() <= 0 || $item->filhos()->get()->whereIn('id_menu', $menus_permitidos)->count() > 0));
		});

		dump($filtered);

	}
	//função que pega a saída em json do componente nestable e monta a ordem do menu bem como sua hierarquia
	public static function organizaMenuSalvar($json, $id_menu_sup = null, $ordem = null)
	{
		//incrementa o contador
		$GLOBALS['ordemMenuTeste'] = $ordem;
		$GLOBALS['ordemMenuTeste']++;

		//se o array tiver elemntos
		if(isset($json) && count($json) > 0)
		{
			//percorre o array
			foreach($json as $index => $item)
			{
				//recupera o menu
				$menu = Menu::find($item->id);
				//seta ordem com o contador
				$menu->ordem_menu = $GLOBALS['ordemMenuTeste'];
				//coloca ou tira o menu superior vinculado
				if(isset($id_menu_sup))
						$menu->id_menu_sup = $id_menu_sup;
				else
					$menu->id_menu_sup = null;
				//se tem filhos chama a função recursivamente
				if(isset($item->children) && count($item->children) > 0)
				{

					Menu::organizaMenuSalvar($item->children, $item->id, $GLOBALS['ordemMenuTeste']);
				}
				//salva as informações modificadas
				$menu->save();
				//só incrementa se não for o último item do foreach
				if(! ($index == (count($json) - 1)))
					$GLOBALS['ordemMenuTeste']++;

			}
		}
	}

	public static function getMaxOrdemMenu()
	{
		$valor = Menu::select(\DB::Raw('max(ordem_menu)'))->get()->first();

		return $valor['max'] ?? 0;
	}




}
