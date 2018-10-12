<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMultasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('multas', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('empleado_id')->unsigned()->index();
            $table->integer('gestion_id')->unsigned()->index();
            $table->integer('periodo_id')->unsigned()->index();

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
        Schema::dropIfExists('multas');
    }
}
