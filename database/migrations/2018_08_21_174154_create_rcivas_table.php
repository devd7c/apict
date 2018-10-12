<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateRcivasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rcivas', function (Blueprint $table) {
            $table->increments('id');
            $table->float('haber_basico');
            $table->float('sueldo');
            $table->float('saldo');//Saldo a favor FISCO
            $table->float('factura');
            $table->float('ans');//Aporte Nacional Solidario
            $table->float('sueldo_neto');//Sueldo neto -AFPS: 12,71% - AFP Nal Solidario
            $table->float('smn2');//Dos sueldos mínimos no imponibles por dependiente
            $table->float('base_imponible');
            $table->float('debito_fiscal');//Débito Fiscal del periodo
            $table->float('credito_fiscal');//Credito Fiscal
            $table->float('smn2_iva');//Cómputo 13% sobre dos SMN
            $table->float('saldo_anterior');
            $table->float('saldo_anterior_actualizado');
            $table->float('saldo_anterior_nuevo');
            $table->float('impuesto_periodo');//Impuesto Determinado en el periodo
            $table->float('credito_fiscal_dependiente');//Credito Fiscal en Uso por el Dependiente

            $table->integer('gestion_id')->unsigned();
            $table->integer('periodo_id')->unsigned();
            $table->integer('empleado_id')->unsigned();

            $table->timestamps();
            $table->softDeletes();//deleted_at

            $table->foreign('gestion_id')->references('id')->on('gestions');
            $table->foreign('periodo_id')->references('id')->on('periodos');
            $table->foreign('empleado_id')->references('id')->on('empleados');
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
        Schema::dropIfExists('rcivas');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}