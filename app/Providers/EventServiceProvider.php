<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
      'App\Events\Event' => [
        'App\Listeners\EventListener',
      ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
      parent::boot();

       //Listeners dos eventos do sistema para a geração dos LOGs

      //Listeners para atribuíções de relações N pra N

      Event::listen(['eloquent.pivotAttached: *'], function ($eventName, array $data)
      {
        //dd($eventName, $data);
        /*
        $relation = " | Relação: ".$data['relation']. " " .implode(", ", $data['pivotIds']);
        $log_dados = implodeWithKeys($data['model']->getAttributes());        
        $log_dados .= $relation;
        $nomeEvento = "Atribuição de ".$data['relation']." de ".substr($eventName,strpos($eventName, "\\")+1);
        */
        
        $relation = " | Relação: ".$data['1']. " " .implode(", ", $data['2']);
        $log_dados = implodeWithKeys($data['0']->getAttributes());        
        $log_dados .= $relation;
        $nomeEvento = "Atribuição de ".$data['1']." de ".substr($eventName,strpos($eventName, "\\")+1);

        \LogAtividades::adicionaAoLog($nomeEvento , $log_dados);
      });

      Event::listen(['eloquent.pivotDetached: *'], function ($eventName, array $data)
      {
        /*
        $relation = " | Relação: ".$data['relation']. " " .implode(", ", $data['pivotIds']);
        $log_dados = implodeWithKeys($data['model']->getAttributes());        
        $log_dados .= $relation;
        $nomeEvento = "Desatribuição de ".$data['relation']." de ".substr($eventName,strpos($eventName, "\\")+1);
        */

        $relation = " | Relação: ".$data['1']. " " .implode(", ", $data['2']);
        $log_dados = implodeWithKeys($data['0']->getAttributes());        
        $log_dados .= $relation;
        $nomeEvento = "Desatribuição de ".$data['1']." de ".substr($eventName,strpos($eventName, "\\")+1);
      });

      //Listener save ouve tanto create como update sendo dividios por: "wasRecentlyCreated"
      Event::listen(['eloquent.saved: *'], function ($eventName, array $data)
      {
        

        if(!isset($data['model']))
          $data['model'] = $data[0];

       // dump($data['model']); dump($data['model']->getAttributes()); dd($data['model']->attributes);
        
        if(substr($eventName,strpos($eventName, "\\")+1) != "LogAtividades"){

         $log_dados = implodeWithKeys($data['model']->getAttributes());     

         if($data['model']->wasRecentlyCreated)
         {
           $nomeEvento = "Criação de ".substr($eventName,strpos($eventName, "\\")+1);
           \LogAtividades::adicionaAoLog($nomeEvento , $log_dados);
         }
         else
         {
          $nomeEvento = "Atualização de ".substr($eventName,strpos($eventName, "\\")+1);
          \LogAtividades::adicionaAoLog($nomeEvento , $log_dados);
        }
      } 
    });     
      
      //Listener deleted grava logs de remoção de dados
      Event::listen(['eloquent.deleted: *'], function ($eventName, array $data)
      {
        if(!isset($data['model']))
          $data['model'] = $data[0];

        $log_dados = implodeWithKeys($data['model']->getAttributes());    
        $nomeEvento = "Exclusão de ".substr($eventName,strpos($eventName, "\\")+1);
        \LogAtividades::adicionaAoLog($nomeEvento , $log_dados);
      });
      
      //registra os logins
      Event::listen('Illuminate\Auth\Events\Login', function ($event) {
        
        \LogAtividades::adicionaAoLog('Login no Sistema', implodeWithKeys($event->user->getAttributes()));
      });
    }
  }
