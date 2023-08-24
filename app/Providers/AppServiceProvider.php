<?php

namespace App\Providers;

use App\Models\MensagemOriginal;
use App\Observers\MensagemOriginalObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Console\Scheduling\Schedule;
use Validator;
use Bouncer;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /*
        $this->commands([
          \App\Console\Commands\ImportContacts::class
        ]);
        */

        $this->app->booted(function () {
          $schedule = $this->app->make(Schedule::class);
          //$schedule->command('import:contacts')->everyMinute();
          
        });
        //insere um validador padrão para o recaptcha
        Validator::extend('valida_recaptcha',
            function($attribute, $value, $parameters, $validator)
            {
                /*CÓDIGO ABAIXO QUE UTILIZA A FUNÇÃO FILE_GET_CONTENTS PAROU DE FUNCIONAR,
                 UM NOVO TRECHO DE CÓDIGO UTILIZANDO CURL FOI ESCRITO LOGO APÓS O TRECHO COMENTADO*/
                /*---------------------------------------------------------------------------*/
                /*$result = file_get_contents
                (
                    'https://www.google.com/recaptcha/api/siteverify', false,
                    stream_context_create
                    (
                        array
                        (
                            'http' =>   array
                                    (
                                        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                                        'method'  => 'POST',
                                        'content' => http_build_query
                                        (
                                            array
                                            (
                                                'response' => $_POST['g-recaptcha-response'],
                                                'secret' => '6Lf0x0YUAAAAABm-IhWOWrl5bWZ1OwltfTYeNE0A'
                                            )
                                        ),
                                    ),
                        )
                    )
                );
                $result = json_decode($result);

                return $result->success ?? false;*/

                /*---------------------------------------------------------------------------*/

            /* SE HOUVER SERVIDOR SEM SUPORTE AO CURL TENTAR UTILIZAR CÓDIGO ACIMA QUE ESTAVA FUNCIONANDO ATÉ A VERSÃO 5.4 EM PRODUÇÃO (APACHE 2.4). */
            
            //$secretKey  = '6LfloNMUAAAAAMszbaGNxMbfybSmaMGBRgdp9xJE'; // Desenv: HTML (6LfloNMUAAAAALzOuMyAbP34z4ICd7BGBnPFV5Qp)
            //$secretKey  = '6LdGodMUAAAAACaILsbsiwNcUhwBwy6h8-2z6LE-'; // Prod: HTML (6LdGodMUAAAAAD4USyTcoGfl5F8iHjy1BN4PWHf4) - SISOP
            //$secretKey  = '6LePhNMUAAAAAD4QHarkof6FKNj7rla3P9z1tLuI'; // Prod: HTML (6LePhNMUAAAAAMrO_IOehzwvbfGTIAK1vf15XPCV) - SICOM
            $secretKey  = '6Lf0x0YUAAAAABm-IhWOWrl5bWZ1OwltfTYeNE0A'; // Prod: HTML (6Lf0x0YUAAAAAFZ8slmbcjgitW9b4s4ry7iFNk3n) - SISLOP
            
            $response = $_POST['g-recaptcha-response'];

            $ch = \curl_init();

            curl_setopt_array($ch, [
                CURLOPT_URL => 'https://www.google.com/recaptcha/api/siteverify',
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => [
                    'secret' => '6LcC3pQjAAAAAONy1XblffJqEM5UuKt1PDP_CmfG',
                    'response' => $response,
                    'remoteip' => $_SERVER['REMOTE_ADDR']
                ],
                CURLOPT_RETURNTRANSFER => true
            ]);

            $output = curl_exec($ch);
            curl_close($ch);

            $result = json_decode($output);


            return $result->success ?? false;
        });

        //passa para o gerenciador de controle de acesso o nome das tabelas
        Bouncer::tables([
            'abilities' => 'habilidade',
            'permissions' => 'habilidade_associada',
            'roles' => 'perfil',
            'assigned_roles' => 'perfil_associado'
        ]);




    }



    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
      $this->app->singleton(\Goutte\Client::class, function ($app) {
      $client = new \Goutte\Client();
      $client->setClient(new \GuzzleHttp\Client([
          'timeout' => 20,
          'allow_redirects' => false,
      ]));

      return $client;
      });
    }
}
