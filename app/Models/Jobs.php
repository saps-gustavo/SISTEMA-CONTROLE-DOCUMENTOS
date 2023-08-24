<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jobs extends Model
{
    protected $connection = 'pgsql';

    protected $table = 'tb_jobs';

	protected $primaryKey = 'cod_jobs';

    protected $fillable = [
        'cod_jobs',
        'queue',
		'payload',
        'attempts',
        'reserved_at',
        'available_at',
        'created_at',
        'id'
	];
    //
}
