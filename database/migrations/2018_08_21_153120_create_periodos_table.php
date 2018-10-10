<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePeriodosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('periodos', function (Blueprint $table) {
            $table->increments('id');
            $table->date('inicio_mes'); //2018-01-01
            $table->date('fin_mes')->nullable(); //2018-01-31
            $table->string('procesado')->default(2); //1=Si, 2=No
            $table->string('cierre')->default(2); //1=Si, 2=No
            $table->float('cierre_ufv')->default(0); //Ejem: 2.14454

            $table->integer('gestion_id')->unsigned();

            $table->timestamps();
            $table->softDeletes();//deleted_at

            $table->foreign('gestion_id')->references('id')->on('gestions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('periodos');
    }
}
