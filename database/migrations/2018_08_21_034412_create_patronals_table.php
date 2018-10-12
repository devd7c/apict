<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreatePatronalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patronals', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('sarp'); // Seguro de Accidentes por Riesgo Profesional = 1.71% con destino a la cuenta colectiva de riesgo profesional, que le da derecho al trabajador dependiente a la cobertura por invalidez o muerte causada por accidente o enfermedad dentro del horario de trabajo
            $table->decimal('provivienda'); // 2% sobre el total ganado, por concepto de aporte de vivienda. Se realiza a las administradoras de Fondos de Pensiones, como aporte para proyectos de viviendas sociales para los trabajadores.
            $table->decimal('infocal');
            $table->decimal('cnss'); // 10% sobre el total ganado, para la cobertura del aporte de salud
            $table->decimal('sip'); // Aporte Patronal Solidario: 3% del total ganado del dependiente, como aporte patronal solidario con destino al fondo solidario
            $table->string('activo')->default('0'); //1=Si, 0=No

            $table->integer('empresa_id')->unsigned();


            $table->timestamps();
            $table->softDeletes();//deleted_at

            $table->foreign('empresa_id')->references('id')->on('empresas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patronals');
    }
}
