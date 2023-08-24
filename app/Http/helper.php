<?php 
use App\User as UserModel;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\QueryException;

if (!function_exists('implodeWithKeys')) 
{
	function implodeWithKeys($array)
	{
		$retorno = '';
		if(isset($array) && is_array($array) && count($array) > 0)
		{			
			$cont = 0;
			foreach($array as $chave => $linha)
			{
				$retorno = $retorno.$chave."=>".$linha.(($cont!=count($array) -1)?',':'');
				$cont++;
			}
		}
		return $retorno;
	}
}

if (!function_exists('manualPaginate')) 
{
	function manualPaginate($items, $perPage = 12)
	{
//Get current page form url e.g. &page=1
		$currentPage = LengthAwarePaginator::resolveCurrentPage();
//Slice the collection to get the items to display in current page
		$currentPageItems = $items->slice(($currentPage - 1) * $perPage, $perPage);
//Create our paginator and pass it to the view
		return new LengthAwarePaginator($currentPageItems, count($items), $perPage);
	}
}

if (!function_exists('relatorio_path'))
{
	function relatorio_path()
	{
		return resource_path().DIRECTORY_SEPARATOR.'relatorios'.DIRECTORY_SEPARATOR;
	}
}

if (!function_exists('pathReport'))
{
	function pathReport()
	{
		return str_replace("\\","/",relatorio_path());
	}
}

if (!function_exists('pathReportOffSet'))
{
	function pathReportOffSet()
	{
		return '..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR.'imagens';
	}
}

if (!function_exists('queryExceptionMessage'))
{
	function queryExceptionMessage(QueryException $e)
	{
		if ($e->errorInfo[0] === "23503"){
			return  "Este item não pode ser excluído porque está associado à outros itens do sistema!";
		}
		elseif ($e->errorInfo[0] === "23505") {
			return  "Este item já existe!";
		}
		else
		{
			return "Ocorreu um erro no Banco de Dados!";
		}
	}
}

if(!function_exists('trocaAcento'))
{
	function trocaAcento($string)
	{
		$tr = strtr(
			$string,
			array 
			(
				'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A',
				'Æ' => 'A', 'Ç' => 'C', 'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E',
				'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I', 'Ð' => 'D', 'Ñ' => 'N',
				'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ø' => 'O',
				'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ý' => 'Y', 'Ŕ' => 'R',
				'Þ' => 's', 'ß' => 'B', 'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a',
				'ä' => 'a', 'å' => 'a', 'æ' => 'a', 'ç' => 'c', 'è' => 'e', 'é' => 'e',
				'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i',
				'ð' => 'o', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o',
				'ö' => 'o', 'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ý' => 'y',
				'þ' => 'b', 'ÿ' => 'y', 'ŕ' => 'r', 'ü' => 'u'
			));
		return $tr;
	}
}