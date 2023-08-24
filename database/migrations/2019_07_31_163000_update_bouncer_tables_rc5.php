<?php

use Silber\Bouncer\Database\Models;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateBouncerTablesRC5 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('pgsql')->table(Models::table('abilities'), function (Blueprint $table) {
			$table->string('name')->change();
			$table->string('entity_type')->nullable()->change();
			$table->json('options')->nullable();
        });

        Schema::connection('pgsql')->table(Models::table('roles'), function (Blueprint $table) {
			$table->string('name')->change();
        });

        Schema::connection('pgsql')->table(Models::table('assigned_roles'), function (Blueprint $table) {
			$table->increments('id');
			$table->string('entity_type')->change();
            $table->integer('restricted_to_id')->unsigned()->nullable();
            $table->string('restricted_to_type')->nullable();
        });

        Schema::connection('pgsql')->table(Models::table('permissions'), function (Blueprint $table) {
			$table->increments('id');
			$table->integer('entity_id')->unsigned()->nullable()->change();
            $table->string('entity_type')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
