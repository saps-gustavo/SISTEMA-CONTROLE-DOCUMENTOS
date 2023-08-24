<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Migrations extends Model
{
    protected $connection = 'pgsql';

    protected $table = 'tb_migrations';

	protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'migration',
		'batch'
	];

    //
}
