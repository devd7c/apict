<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmpleadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empleados', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tipo_doc'); //1=CI, 2=RUN, 3=Pasaporte, 4=Carnet de extranjero o 5=Otro
            $table->string('nro_doc');
            $table->string('exp_doc'); //Ejm: LP = La Paz
            $table->string('afiliacion'); //1=Previsión, 2=Futuro de Bolivia y 3=Otra
            $table->string('nua_cua'); //Asig. por AFP´s. Ingrese el número identificador del dependiente asignado por las AFP´s.
            $table->string('ap_paterno');
            $table->string('ap_materno');
            $table->string('ap_casada')->nullable();
            $table->string('nombre');
            $table->string('nacionalidad');
            $table->date('fecha_nacimiento');
            $table->string('sexo'); //1=F, 2=M
            $table->string('jubilado'); //1=Si, 2=No
            $table->date('fecha_ingreso');
            $table->date('fecha_retiro')->nullable();
            $table->decimal('haber_basico');
            $table->string('nro_matricula');
            $table->string('categoria'); // Es de acuerdo con los años trabajados, ej.: el escalafón del magisterio.
            $table->string('domicilio');
            $table->string('obrero'); //1=Si, 2=No
            $table->integer('empresa_id')->unsigned()->index();
            $table->integer('sucursal_id')->unsigned()->index();
            $table->integer('contrato_id')->unsigned()->index();
            $table->integer('puesto_id')->unsigned()->index();
            $table->integer('cargo_id')->unsigned()->index();
            $table->timestamps();
            $table->softDeletes();//deleted_at

            $table->foreign('empresa_id')->references('id')->on('empresas');
            $table->foreign('sucursal_id')->references('id')->on('sucursals');
            $table->foreign('contrato_id')->references('id')->on('contratos');
            $table->foreign('puesto_id')->references('id')->on('puestos');
            $table->foreign('cargo_id')->references('id')->on('cargos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('empleados');
    }
}
