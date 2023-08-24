<?php

use Illuminate\Database\Seeder;
use App\Perfil;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsuarioSeeder::class);
        $this->call(FuncionalidadeSeeder::class);
        $this->call(PerfilSeeder::class);
        $this->call(HabilidadeSeeder::class);
        $this->call(HabilidadeAssociadaSeeder::class);
        $this->call(PerfilUsuarioSeeder::class); //seta permissões para o perfil administrador

        // SEEDER DO MENU COMENTADO POR INCOMPATIBILIDADE COM A GERENCIA DO MENU PELA INTERFACE GRAFICA, USE UM DOS DOIS
        //$this->call(MenuSeeder::class);
    }
}
