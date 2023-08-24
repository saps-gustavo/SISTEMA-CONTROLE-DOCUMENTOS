<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GrupoUsuario extends Model
{
    protected $connection = 'pgsql';

    protected $table = 'tb_grupo_usuario';

	protected $primaryKey = 'cod_grupo_usuario';

    protected $fillable = [
        'cod_grupo_usuario',
        'desc_grupo_usuario',
		'status',
        'created_at',
        'updated_at',
        'id_grupo_usuario'
	];

    //
}
