<?php

use App\Empresa;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmpresasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->string('nit');
            $table->string('nombre_rep_legal');
            $table->string('titulo_rep_legal');
            $table->string('tipo_doc');
            $table->string('nro_doc');
            $table->string('exp_doc'); //Ejm: LP = La Paz

            $table->timestamps();
            $table->softDeletes();//deleted_at
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
        Schema::dropIfExists('empresas');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
