<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CEPController extends Controller
{
	public function consultar(Request $request)
	{
		try{

			$data = $request->all();

			// CEP (deixa somente os números)
			$cep = preg_replace("/\D/","", $data['cep']);

			// Inicializa o cURL
            $curl = curl_init();

            $headers = array(
                'Content-Type: application/json'
            );

            // URL da Api
            $url_api = "https://viacep.com.br/ws/".$cep."/json/";

            // Parâmetros cURL
            curl_setopt($curl, CURLOPT_URL, $url_api);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

            $output = curl_exec($curl); // Retorno da API
            
            $info = curl_getinfo($curl);
            $status_url = $info["http_code"];

            curl_close($curl);

			$retorno = [
				'logradouro' => '',
				'bairro' => ''
			];

            if ($status_url == "200"){

				$retorno = json_decode($output); // Pega a parte que contém as informações

				if(isset($retorno->erro)){

					return response()->json(
						[
							'status' => false,
							'mensagem' => null,
							'endereco' => $retorno
						], 200);

				}else{

					$retorno = [
						'logradouro' => $retorno->logradouro,
						'bairro' => $retorno->bairro
					];

					return response()->json(
						[
							'status' => true,
							'mensagem' => null,
							'endereco' => $retorno
						], 200);
				}
            }else{
				return response()->json(
					[
						'status' => false,
						'mensagem' => null,
						'endereco' => $retorno
					], 200);
			}

		}
		catch(\Exception $e)
		{
			return response()->json(
				[
					'status' => false,
					'mensagem' => $e->getMessage(),
					'retorno' => null
				], 200);
		}
	}
}
