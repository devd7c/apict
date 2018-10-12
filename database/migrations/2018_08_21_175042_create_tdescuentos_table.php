<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTdescuentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tdescuentos', function (Blueprint $table) {
            $table->increments('id');
            $table->float('monto');
            $table->date('fecha');
            $table->string('descripcion');

            $table->integer('descuento_id')->unsigned();

            $table->timestamps();
            $table->softDeletes();//deleted_at

            $table->foreign('descuento_id')->references('id')->on('descuentos');
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
        Schema::dropIfExists('tdescuentos');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
