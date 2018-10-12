<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateTdomingosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tdomingos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cantidad');
            $table->float('monto');
            $table->date('fecha');
            $table->string('descripcion');

            $table->integer('domingo_id')->unsigned();

            $table->timestamps();
            $table->softDeletes();//deleted_at

            $table->foreign('domingo_id')->references('id')->on('domingos');
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
        Schema::dropIfExists('tdomingos');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
