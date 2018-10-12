<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateThorasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('thoras', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cantidad');
            $table->float('monto');
            $table->date('fecha');
            $table->string('descripcion');

            $table->integer('hora_id')->unsigned();

            $table->timestamps();
            $table->softDeletes();//deleted_at

            $table->foreign('hora_id')->references('id')->on('horas');
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
        Schema::dropIfExists('thoras');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
