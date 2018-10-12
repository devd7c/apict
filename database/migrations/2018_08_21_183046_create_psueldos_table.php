<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePsueldosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('psueldos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('categoria'); // Es de acuerdo con los años trabajados, ej.: el escalafón del magisterio.
            $table->string('obrero'); //1=Si, 2=No
            $table->string('jubilado'); //1=Si, 2=No
            $table->string('dias_pagados');
            $table->string('horas_pagados');
            $table->decimal('haber_basico');
            // Bonos
            $table->string('antiguedad'); // 1,2,3,4,5 en años
            $table->decimal('bono_antiguedad');
            $table->decimal('thoras');
            $table->decimal('tdomingos');
            $table->decimal('tbonos');
            // Descuentos
            $table->decimal('tmultas');
            $table->decimal('tdescuentos');
            $table->decimal('tsip'); // S.I.P. 12.71%
            $table->decimal('trciva'); // RC. IVA 13%

            $table->integer('empleado_id')->unsigned();
            $table->integer('sucursal_id')->unsigned();
            $table->integer('contrato_id')->unsigned();
            $table->integer('puesto_id')->unsigned();
            $table->integer('cargo_id')->unsigned();
            $table->integer('proceso_id')->unsigned();

            $table->timestamps();
            $table->softDeletes();//deleted_at

            $table->foreign('empleado_id')->references('id')->on('empleados');
            $table->foreign('sucursal_id')->references('id')->on('sucursals');
            $table->foreign('contrato_id')->references('id')->on('contratos');
            $table->foreign('puesto_id')->references('id')->on('puestos');
            $table->foreign('cargo_id')->references('id')->on('cargos');
            $table->foreign('proceso_id')->references('id')->on('procesos');

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
        Schema::dropIfExists('psueldos');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
