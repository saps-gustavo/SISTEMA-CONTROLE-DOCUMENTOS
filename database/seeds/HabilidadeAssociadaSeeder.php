<?php

use Illuminate\Database\Seeder;
use App\Permissao;
use App\Perfil;

class HabilidadeAssociadaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Associa a funcionalidade All Abilities (*) ao perfil admin
        Bouncer::allow('admin')->everyThing();
    }
}
