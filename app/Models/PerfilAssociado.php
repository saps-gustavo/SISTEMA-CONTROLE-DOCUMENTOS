<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PerfilAssociado extends Model
{
    protected $connection = 'pgsql';

    protected $table = 'tb_perfil_associado';

	protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'role_id',
		'entity_id',
        'entity_type',
        'scope',
        'retricted_to_id',
        'retricted_to_type'
	];
    //
}
