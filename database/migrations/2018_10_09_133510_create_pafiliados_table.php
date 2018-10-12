<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePafiliadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pafiliados', function (Blueprint $table) {
            $table->increments('id');
            $table->string('dias_cotizados');
            $table->string('afiliacion'); //1=Previsión, 2=Futuro de Bolivia y 3=Otra
            $table->string('edad'); // años

            //Total ganado dependiente < 65 años dependiente con pension del SIP < 65 años que decide aportar al SIP
            $table->decimal('tgmenor65_depsip');
            //Total ganado dependiente > 65 años dependiente con pension del SIP > 65 años que decide aportar al SIP
            $table->decimal('tgmayor65_depsip');
            //Total ganado dependiente < 65 años asegurado con pension del SIP < 65 años que decide NO aportar al SIP
            $table->decimal('tgmenor65_asegnosip');
            //Total ganado dependiente > 65 años asegurado con pension del SIP > 65 años que decide aportar al SIP
            $table->decimal('tgmayor65_asegsip');

            $table->decimal('cotizacion_adicional');

            $table->integer('empleado_id')->unsigned();
            $table->integer('proceso_id')->unsigned();

            $table->timestamps();
            $table->softDeletes();//deleted_at

            $table->foreign('empleado_id')->references('id')->on('empleados');
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
        Schema::dropIfExists('pafiliados');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
