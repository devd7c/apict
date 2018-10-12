<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateProcesosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('procesos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('empresa_id')->unsigned();
            $table->integer('gestion_id')->unsigned();
            $table->integer('periodo_id')->unsigned();
            $table->integer('regperiodo_id')->unsigned();
            $table->integer('patronal_id')->unsigned();
            $table->integer('laboral_id')->unsigned();

            $table->timestamps();
            $table->softDeletes();//deleted_at

            $table->foreign('empresa_id')->references('id')->on('empresas');
            $table->foreign('gestion_id')->references('id')->on('gestions');
            $table->foreign('periodo_id')->references('id')->on('periodos');
            $table->foreign('regperiodo_id')->references('id')->on('regperiodos');
            $table->foreign('patronal_id')->references('id')->on('patronals');
            $table->foreign('laboral_id')->references('id')->on('laborals');

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
        Schema::dropIfExists('procesos');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
