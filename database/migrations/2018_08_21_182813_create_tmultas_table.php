<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTmultasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tmultas', function (Blueprint $table) {
            $table->increments('id');
            $table->float('monto');
            $table->date('fecha');
            $table->string('descripcion');

            $table->integer('multa_id')->unsigned();

            $table->timestamps();
            $table->softDeletes();//deleted_at

            $table->foreign('multa_id')->references('id')->on('multas');
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
        Schema::dropIfExists('tmultas');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
