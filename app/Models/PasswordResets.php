<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordResets extends Model
{
    protected $connection = 'pgsql';

    protected $table = 'tb_password_resets';

    protected $fillable = [
        'email',
        'token',
		'created_at'
	];
    //
}
