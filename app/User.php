<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Perfil;
use App\Notifications\ResetaSenha;
use App\Notifications\EmailConvite;
use Fico7489\Laravel\Pivot\Traits\PivotEventTrait;
use Silber\Bouncer\Database\HasRolesAndAbilities;

class User extends Authenticatable
{
	use Notifiable;
//necessario para que o evento syncWithoutDetaching seja disparado
	use PivotEventTrait;

	use HasRolesAndAbilities;

	protected $table = "usuario";

	/**
	* The attributes that are mass assignable.
	*
	* @var array
	*/

	protected $primaryKey = 'id_usuario';

	protected $fillable = [
        'id_usuario',
        'nome_usuario',
        'email',
        'password',
        'status',
        'created_at',
        'updated_at',
        'remenber_token',
        'inscr_cpf_usuario',
        'qtd_acessos_usuario',
        'qtd_acessos_senha',
        'cod_status_atividade',
        'dt_criacao_usuario',
        'dt_hr_ultimo_acesso',
        'dt_hr_senha',
        'dt_hr_inatividade',
        'cod_status_operacao_user',
        'cod_troca_senha'

	];

	/**
	* The attributes that should be hidden for arrays.
	*
	* @var array
	*/
	protected $hidden = [
		'senha','password', 'remember_token',
	];

	// public function perfis(){
	// 	return $this->belongsToMany('App\Perfil', 'perfil_usuario', 'id_usuario', 'id_perfil');
	// }

	public function administrador()
	{
		$usuario = auth()->user();auth();
		if(\Bouncer::is($usuario)->an('admin'))
			return true;
		else
			return false;
	}

	public function sendPasswordResetNotification($token)
	{
		$this->notify(new ResetaSenha($token));
	}

	public function habilidadesPermitidas()
	{
		//pega habilidades usuario
		if($this->getAbilities()->contains('name', '*'))
			$habilidades = \Bouncer::ability()->get();
		else
			$habilidades = $this->getAbilities();

		$habilidades_negadas = $this->abilities()->wherePivot('forbidden', true)->get();

		if($habilidades_negadas->count() > 0)
			$habilidades = $habilidades->diff($habilidades_negadas);

		return $habilidades;
	}

	public function TodasHabilidades()
	{
		//pega todas as habilidades
		$habilidades = \Bouncer::ability()->get();

		return $habilidades;
	}

	public function listaFuncionalidades()
	{
		$habs = $this->habilidadesPermitidas();

		$ids_funcionalidade = $habs->pluck('id_funcionalidade')->toArray();

		$ids_funcionalidade = array_filter($ids_funcionalidade, function($var){return !is_null($var);} );

		$funcs = Funcionalidade::with('habilidades')->distinct()->whereIn('id_funcionalidade', $ids_funcionalidade)
		->orderBy('nome_funcionalidade')->get();

		return $funcs;

	}

	public function getPrimeiroNome()
	{
		$primeiroNome = explode(" ", $this->nome_usuario);
		return $primeiroNome[0];
	}

}
