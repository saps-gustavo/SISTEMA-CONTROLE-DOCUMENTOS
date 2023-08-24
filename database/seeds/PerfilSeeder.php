<?php

use Illuminate\Database\Seeder;
use App\Perfil;

class PerfilSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //CRIA PERFIS

        $admin = Bouncer::role()->firstOrCreate([
            'name' => 'admin',
            'title' => 'Administrador',
        ]);

        $basico = Bouncer::role()->firstOrCreate([
            'name' => 'basico',
            'title' => 'Básico',
        ]);

        $basico = Bouncer::role()->firstOrCreate([
            'name' => 'teste',
            'title' => 'Teste',
        ]);
    }
}
