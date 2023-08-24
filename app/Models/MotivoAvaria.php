<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MotivoAvaria extends Model
{
    protected $connection = 'pgsql';

    protected $table = 'motivo_avaria';

	protected $primaryKey = 'id_motivo_avaria';

    protected $fillable = [
        'desc_motivo_avaria',
        'uniqid',
		'created_at',
		'updated_at'
	];
}
