<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSucursalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sucursals', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->string('direccion');
            $table->string('nit');
            $table->string('ciudad');
            $table->string('fono');
            $table->string('nro_pat');

            $table->integer('empresa_id')->unsigned();

            $table->timestamps();
            $table->softDeletes();//deleted_at

            $table->foreign('empresa_id')->references('id')->on('empresas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('sucursals');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
