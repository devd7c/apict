<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHorasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('horas', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('empleado_id')->unsigned();
            $table->integer('gestion_id')->unsigned();
            $table->integer('periodo_id')->unsigned();


            $table->timestamps();
            $table->softDeletes();//deleted_at

            $table->foreign('empleado_id')->references('id')->on('empleados');
            $table->foreign('gestion_id')->references('id')->on('gestions');
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
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('horas');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
