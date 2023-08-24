<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Bouncer;

class Funcionalidade extends Model
{
    protected $table = 'funcionalidade';

    protected $primaryKey = 'id_funcionalidade';

    protected $fillable = [
        'nome_funcionalidade',
        'desc_funcionalidade',
        'updated_at',
        'created_at',
        'apelido',
        'model'
    ];

    public function habilidades()
    {
    	return $this->hasMany('Silber\Bouncer\Database\Ability','id_funcionalidade');
    }

    public function menu()
    {
    	return $this->hasMany('App\Menu', 'id_funcionalidade');
    }

    public static function funcionalidadesPorPerfil($perfil)
    {
        try
        {
            //pega o perfil
            if(is_int($perfil))
                $perfil = \Bouncer::role()->findOrFail($perfil);
            elseif(!get_class($perfil) == 'Silber\Bouncer\Database\Role')
                throw new \Exception('Parâmetros Incorretos');
            //pega todas as habilidades do perfil
            $habilidades = $perfil->getAbilities();

            //se possui a permissão total retorna todas as funcionalidades
            if($habilidades->contains('name', '*'))
                return Funcionalidade::with('habilidades')->get();

            //extrai as funcionalidades do perfil
            $funcionalidades = $habilidades->unique('id_funcionalidade')->pluck('id_funcionalidade');

            //monta a coleção com as funcionalidades e as habilidades do perfil associadas
            $colecao_funcionalidades = new Collection();

            if(count($funcionalidades) > 0)
            {
                foreach($funcionalidades as $func)
                {
                    if($func != null)
                    {
                        $item = Funcionalidade::findOrFail($func);
                        $item->habilidades = $habilidades->where('id_funcionalidade', $func);
                        $colecao_funcionalidades->push($item);
                    }
                }
            }

            return $colecao_funcionalidades;
        }
        catch (\Exception $e)
        {
            return $e->getMessage();
        }
    }

     public static function funcionalidadesPorUsuario($usuario)
    {
        try
        {
            //pega o perfil
            if(is_int($usuario))
                $usuario = User::findOrFail($usuario);
            elseif(!get_class($usuario) == 'App/User')
                throw new \Exception('Parâmetros Incorretos');

            $habilidades = auth()->user()->habilidadesPermitidas();
            

            //extrai as funcionalidades do perfil
            $funcionalidades = $habilidades->unique('id_funcionalidade')->pluck('id_funcionalidade');

            //monta a coleção com as funcionalidades e as habilidades do perfil associadas
            $colecao_funcionalidades = new Collection();

            if(count($funcionalidades) > 0)
            {
                foreach($funcionalidades as $func)
                {
                    if($func != null)
                    {
                        $item = Funcionalidade::findOrFail($func);
                        $item->habilidades = $habilidades->where('id_funcionalidade', $func);
                        $colecao_funcionalidades->push($item);
                    }
                }
            }

            return $colecao_funcionalidades;
        }
        catch (\Exception $e)
        {
            return $e->getMessage();
        }
    }

    public static function funcionalidadesTodas($usuario)
    {
        try
        {
            //pega o perfil
            if(is_int($usuario))
                $usuario = User::findOrFail($usuario);
            elseif(!get_class($usuario) == 'App/User')
                throw new \Exception('Parâmetros Incorretos');

            $habilidades = auth()->user()->TodasHabilidades();

            //extrai as funcionalidades do perfil
            $funcionalidades = $habilidades->unique('id_funcionalidade')->pluck('id_funcionalidade');

            //monta a coleção com as funcionalidades e as habilidades do perfil associadas
            $colecao_funcionalidades = new Collection();

            if(count($funcionalidades) > 0)
            {
                foreach($funcionalidades as $func)
                {
                    if($func != null)
                    {
                        $item = Funcionalidade::findOrFail($func);
                        $item->habilidades = $habilidades->where('id_funcionalidade', $func);
                        $colecao_funcionalidades->push($item);
                    }
                }
            }

            return $colecao_funcionalidades;
        }
        catch (\Exception $e)
        {
            return $e->getMessage();
        }
    }

    public static function getHabilidadesWithFuncionalidade()
    {
        return Bouncer::ability()->leftJoin('funcionalidade','funcionalidade.id_funcionalidade','=','habilidade.id_funcionalidade')
        ->orderBy('name')->get();
    }
}
