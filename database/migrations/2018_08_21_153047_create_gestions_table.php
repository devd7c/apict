<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gestions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('periodo_inicio'); //Ejem: 2018
            $table->string('periodo_rango'); //1=Enero-Diciembre, 2=Abril-Marzo 3=Octubre-Septiembre
            $table->string('activo')->default('1'); //1=Si, 2=No

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
        Schema::dropIfExists('gestions');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
