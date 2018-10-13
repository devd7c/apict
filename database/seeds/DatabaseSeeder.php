<?php

use App\User;
use App\Category;
use App\Product;
use App\Transaction;

use App\Empresa;
use App\Sucursal;
use App\Gestion;
use App\Periodo;
use App\Regperiodo;
use App\Contrato;
use App\Puesto;
use App\Cargo;
use App\Laboral;
use App\Patronal;
use App\Empleado;
use App\Hora;
use App\Thora;
use App\Domingo;
use App\Tdomingo;
use App\Bono;
use App\Tbono;
use App\Multa;
use App\Tmulta;
use App\Descuento;
use App\Tdescuento;
//use App\Rciva;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */

    public function run()
    {
        // POSTRESQL DEFINE
        /*DB::statement("TRUNCATE TABLE users RESTART IDENTITY CASCADE");
        DB::statement("TRUNCATE TABLE categories RESTART IDENTITY CASCADE");
        DB::statement("TRUNCATE TABLE products RESTART IDENTITY CASCADE");
        DB::statement("TRUNCATE TABLE transactions RESTART IDENTITY CASCADE");
        DB::statement("TRUNCATE TABLE empresas RESTART IDENTITY CASCADE");
        DB::statement("TRUNCATE TABLE sucursals RESTART IDENTITY CASCADE");
        DB::statement("TRUNCATE TABLE gestions RESTART IDENTITY CASCADE");
        DB::statement("TRUNCATE TABLE periodos RESTART IDENTITY CASCADE");
        DB::statement("TRUNCATE TABLE regperiodos RESTART IDENTITY CASCADE");
        DB::statement("TRUNCATE TABLE contratos RESTART IDENTITY CASCADE");
        DB::statement("TRUNCATE TABLE puestos RESTART IDENTITY CASCADE");
        DB::statement("TRUNCATE TABLE cargos RESTART IDENTITY CASCADE");
        DB::statement("TRUNCATE TABLE laborals RESTART IDENTITY CASCADE");
        DB::statement("TRUNCATE TABLE patronals RESTART IDENTITY CASCADE");
        DB::statement("TRUNCATE TABLE empleados RESTART IDENTITY CASCADE");
        DB::statement("TRUNCATE TABLE horas RESTART IDENTITY CASCADE");
        DB::statement("TRUNCATE TABLE thoras RESTART IDENTITY CASCADE");
        DB::statement("TRUNCATE TABLE domingos RESTART IDENTITY CASCADE");
        DB::statement("TRUNCATE TABLE tdomingos RESTART IDENTITY CASCADE");
        DB::statement("TRUNCATE TABLE bonos RESTART IDENTITY CASCADE");
        DB::statement("TRUNCATE TABLE tbonos RESTART IDENTITY CASCADE");
        DB::statement("TRUNCATE TABLE multas RESTART IDENTITY CASCADE");
        DB::statement("TRUNCATE TABLE tmultas RESTART IDENTITY CASCADE");
        DB::statement("TRUNCATE TABLE descuentos RESTART IDENTITY CASCADE");
        DB::statement("TRUNCATE TABLE tdescuentos RESTART IDENTITY CASCADE");*/

        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        User::truncate();
        Category::truncate();
        Product::truncate();
        Transaction::truncate();

        Empresa::truncate();
        Sucursal::truncate();
        Gestion::truncate();
        Periodo::truncate();
        Regperiodo::truncate();
        Contrato::truncate();
        Puesto::truncate();
        Cargo::truncate();
        Laboral::truncate();
        Patronal::truncate();
        Empleado::truncate();
        Hora::truncate();
        Thora::truncate();
        Domingo::truncate();
        Tdomingo::truncate();
        Bono::truncate();
        Tbono::truncate();
        Multa::truncate();
        Tmulta::truncate();
        Descuento::truncate();
        Tdescuento::truncate();
        //Rciva::truncate();

        DB::table('category_product')->truncate();

        User::flushEventListeners();
        Category::flushEventListeners();
        Product::flushEventListeners();
        Transaction::flushEventListeners();

        Empresa::flushEventListeners();
        Sucursal::flushEventListeners();
        Gestion::flushEventListeners();
        Periodo::flushEventListeners();
        Regperiodo::flushEventListeners();
        Contrato::flushEventListeners();
        Puesto::flushEventListeners();
        Cargo::flushEventListeners();
        Laboral::flushEventListeners();
        Patronal::flushEventListeners();
        Empleado::flushEventListeners();
        Hora::flushEventListeners();
        Thora::flushEventListeners();
        Domingo::flushEventListeners();
        Tdomingo::flushEventListeners();
        Bono::flushEventListeners();
        Tbono::flushEventListeners();
        Multa::flushEventListeners();
        Tmulta::flushEventListeners();
        Descuento::flushEventListeners();
        Tdescuento::flushEventListeners();
        //Rciva::flushEventListeners();

        $usersQuantity = 100;
        $categoriesQuantity = 30;
        $productsQuantity = 100;
        $transactionsQuantity = 100;

        $empresaQuantity = 1;
        $sucursalQuantity = 9;
        $gestionQuantity = 1;
        $periodoQuantity = 1;
        $regPeriodoQuantity = 2;
        $contratoQuantity = 5;
        $puestoQuantity = 10;
        $cargoQuantity = 15;
        $laboralQuantity = 1;
        $patronalQuantity = 1;
        $empleadoQuantity = 20;
        $horaQuantity = 2;
        $thoraQuantity = 5;
        $domingoQuantity = 1;
        $tDomingoQuantity = 3;
        $bonoQuantity = 3;
        $tBonoQuantity = 5;
        $multaQuantity = 2;
        $tMultaQuantity = 4;
        $descuentoQuantity = 3;
        $tDescuentoQuantity = 4;

        factory(User::class, $usersQuantity)->create();
        factory(Category::class, $categoriesQuantity)->create();
        factory(Product::class, $productsQuantity)->create()->each(
            function ($product) {
                $categories = Category::all()->random(mt_rand(1, 5))->pluck('id');

                $product->categories()->attach($categories);
            });
        factory(Transaction::class, $transactionsQuantity)->create();

        factory(Empresa::class, $empresaQuantity)->create();
        factory(Sucursal::class, $sucursalQuantity)->create();
        factory(Gestion::class, $gestionQuantity)->create();
        factory(Periodo::class, $periodoQuantity)->create();
        factory(Regperiodo::class, $regPeriodoQuantity)->create();
        factory(Contrato::class, $contratoQuantity)->create();
        factory(Puesto::class, $puestoQuantity)->create();
        factory(Cargo::class, $cargoQuantity)->create();
        factory(Laboral::class, $laboralQuantity)->create();
        factory(Patronal::class, $patronalQuantity)->create();
        factory(Empleado::class, $empleadoQuantity)->create();
        factory(Hora::class, $horaQuantity)->create();
        factory(Thora::class, $thoraQuantity)->create();
        factory(Domingo::class, $domingoQuantity)->create();
        factory(Tdomingo::class, $tDomingoQuantity)->create();
        factory(Bono::class, $bonoQuantity)->create();
        factory(Tbono::class, $tBonoQuantity)->create();
        factory(Multa::class, $multaQuantity)->create();
        factory(Tmulta::class, $tMultaQuantity)->create();
        factory(Descuento::class, $descuentoQuantity)->create();
        factory(Tdescuento::class, $tDescuentoQuantity)->create();

        /*factory(Empleado::class, $empleadoQuantity)
            ->create()
            ->each(function (Empleado $empleado) {
                if (($empleado->haber_basico) > 9440) {
                    $smn = Laboral::all()->random()->smn * 2;
                    $afp = ($empleado->haber_basico * 12.71 / 100);
                    $baseImponible = ($empleado->haber_basico - $afp) - $smn;
                    $rciva = $baseImponible * (Laboral::all()->random()->iva) / 100;
                    $saldo = $rciva - ($smn * 13 / 100);

                    if ($saldo > 0){
                        factory(Rciva::class)
                            ->create([
                                'monto' => $empleado->haber_basico,
                                'saldo' => $saldo,
                                'factura' => $saldo,
                                'empleado_id' => $empleado->id,
                                'periodo_id' => Periodo::all()->random()->id,
                            ]);
                    }
                }
            });*/
        //factory(Rciva::class, $empleadoQuantity)->create();
    }
}
