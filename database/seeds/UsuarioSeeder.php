<?php

use Illuminate\Database\Seeder;
use App\User;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //CRIA USUARIOS

        //usuario adminstrador, qualquer mudança no banco de dados pelo tinker, seeder, ou outro onde não houver login usará esse usuario
        User::firstOrCreate(['email'=>'saps@pjf.mg.gov.br'],['nome_usuario'=>'SAPS','password'=>bcrypt("123456"),'status' => '1']);

    }
}
