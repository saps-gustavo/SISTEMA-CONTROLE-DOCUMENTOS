<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    protected $connection = 'pgsql';

    protected $table = 'tb_perfil';

	protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'name',
        'title',
        'level',
        'escope',
        'created_at',
        'updated_at'
    ];
    //
}
