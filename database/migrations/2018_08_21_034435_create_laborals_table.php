<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLaboralsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laborals', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('smn'); // Salario Mínimo Nacional = 10% del total ganado, con destino a la cuenta personal Previsional del trabajador dependiente, lo cual le permitirá acceder a una pensión por vejez vitalicia
            $table->decimal('civ'); // Cuenta Individual de Vejez = 10% del total ganado, con destino a la cuenta personal Previsional del trabajador dependiente, lo cual le permitirá acceder a una pensión por vejez vitalicia
            $table->decimal('si'); // Seguro de Invalidez = 1.71% del total ganado, con destino a la cuenta colectiva de riesgo común, que le da derecho al trabajador dependiente a la cobertura por invalidez o muerte causada por accidente o enfermedad fuera del horario de trabajo
            $table->decimal('comision_afp'); //  0.5% del total ganado, por concepto de comisión a la gestora por la administración de los aportes de la cuenta personal previsional del trabajador dependiente
            $table->decimal('provivienda');
            $table->decimal('iva');
            $table->decimal('asa'); // Aporte Solidario del Asegurado (ASA) = 0.5% del total ganado, por concepto de aporte solidario del asegurado con destino al fondo solidario.
            $table->decimal('ans_13'); // Mayor a Bs. 13.000 * (total ganado menos Bs. 13.000) x 1%
            $table->decimal('ans_25'); // Mayor a Bs. 25.000 * (total ganado menos Bs. 25.000) x 5%
            $table->decimal('ans_35'); // Mayor a Bs. 35.000 *(total ganado menos Bs. 35.000) x 10%
            /*
             * Calculo Bono de Antigüedad: El bono de antigüedad nace sobre la base de un mínimo nacional con el D.S. N° 21060,
             * se amplió a que la base sea de dos y por último de tres mínimos nacionales para las empresas del sector productivo.
             * Las empresas No Productivas mantienen un mínimo nacional de acuerdo con lo dispuesto por el D.S. 23113,
             * de 10 de abril de 1992
             * */
            $table->decimal('cba_1');
            $table->decimal('cba_2');
            $table->decimal('cba_3');
            $table->decimal('cba_4');
            $table->decimal('cba_5');
            $table->decimal('cba_6');
            $table->decimal('cba_7');
            $table->string('activo')->default('0'); //1=Si, 0=No

            $table->integer('empresa_id')->unsigned()->index();

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
        Schema::dropIfExists('laborals');
    }
}
