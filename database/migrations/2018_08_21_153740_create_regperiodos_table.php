<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegperiodosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('regperiodos', function (Blueprint $table) {
            $table->increments('id');
            $table->date('fecha');
            $table->float('tipo_cambio');
            $table->float('ufv');
            $table->string('activo'); //1=Si, 0=No

            $table->integer('periodo_id')->unsigned();

            $table->timestamps();
            $table->softDeletes();//deleted_at

            $table->foreign('periodo_id')->references('id')->on('periodos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('regperiodos');
    }
}
