<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Perfil;

class PerfilUsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //ASSOCIA PERFIS AOS USUÁRIOS RECUPERADOS ABAIXO
        $usuarioSaps = User::where("email","saps@pjf.mg.gov.br")->first();

        Bouncer::assign('admin')->to($usuarioSaps);

    }
}
