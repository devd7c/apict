<?php

use App\User;
use App\Seller;
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
use App\Rciva;

use Faker\Generator as Faker;
/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/
$factory->define(User::class, function (Faker $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
        'verified' => $verified = $faker->randomElement([User::VERIFIED_USER, User::UNVERIFIED_USER]),
        'verification_token' => $verified == User::VERIFIED_USER ? null : User::generateVerificationCode(),
        'admin' => $verified = $faker->randomElement([User::ADMIN_USER, User::REGULAR_USER]),
    ];
});

$factory->define(Empresa::class, function (Faker $faker){
    return [
        'nombre' => $faker->company,
        'nit' => $faker->numberBetween(121542244, 954515454),
        'nombre_rep_legal' => $faker->name,
        'titulo_rep_legal' => $faker->jobTitle,
        'tipo_doc' => $faker->randomElement(['1', '2', '3', '4', '5']),
        'nro_doc' => $faker->numberBetween(5123457, 7854126),
        'exp_doc' => $faker->randomElement(['CB', 'LP']),
    ];
});

$factory->define(Sucursal::class, function (Faker $faker){
    return [
        'nombre' => $faker->company,
        'direccion' => $faker->paragraph(1),
        'nit' => $faker->numberBetween(121542244, 954515454),
        'ciudad' => $faker->unique()->randomElement([
            'La Paz',
            'Cochabamba',
            'Santa Cruz',
            'Beni',
            'Oruro',
            'Potosi',
            'Sucre',
            'Tarija',
            'Pando',
        ]),
        'fono' => $faker->phoneNumber,
        'nro_pat' => $faker->numberBetween(1821542244, 1954515454),
        'empresa_id' => Empresa::all()->random()->id,
    ];
});

$factory->define(Gestion::class, function (Faker $faker) {
    static $password;

    return [
        'periodo_inicio' => $faker->randomElement(['2018']),
        'periodo_rango' => $faker->randomElement(['1']),
        'activo' => $faker->randomElement(['1']),
        'empresa_id' => Empresa::all()->random()->id,
    ];
});

$factory->define(Periodo::class, function (Faker $faker){
    return [
        'inicio_mes' => $faker->randomElement(['2018-10-01']),
        'fin_mes' => $faker->randomElement(['2018-10-31']),
        'procesado' => $faker->randomElement(['2']),
        'cierre' => $faker->randomElement(['2']),
        'cierre_ufv' => $faker->randomElement(['0']),
        'gestion_id' => Gestion::all()->random()->id,
    ];
});

$factory->define(Regperiodo::class, function (Faker $faker){
    return [
        'fecha' => $faker->randomElement(['2018-10-01', '2018-10-31']),
        'tipo_cambio' => $faker->randomFloat(2, 6.96, 6.98),
        'ufv' => $faker->randomFloat(5, 2.27831, 2.28831),
        'activo' => $faker->unique()->randomElement([
            '2',
            '1',
        ]),
        'periodo_id' => Periodo::all()->random()->id,
    ];
});

$factory->define(Contrato::class, function (Faker $faker){
    return [
        'nombre' => $faker->unique()->randomElement([
            'Tiempo indefinido',
            'A plazo fijo',
            'Por temporada',
            'Por realización de obra o servicio',
            'Condicional o eventual',
        ]),
        'descripcion' => $faker->paragraph(1),
    ];
});

$factory->define(Puesto::class, function (Faker $faker){
    return [
        'nombre' => $faker->unique()->randomElement([
            'Ocupaciones de dirección en la administración pública y empresas',
            'Ocupaciones de profesionales científicos e intelectuales',
            'Ocupaciones de técnicos y profesionales de apoyo',
            'Empleados de oficina',
            'Trabajadores de los servicios y vendedores del comercio',
            'Productores y trabajadores en la agricultura, pecuaria, agropecuaria y pesca',
            'Trabajadores de la industria extractiva, construcción, industria manufacturera y otros oficios',
            'Operadores de instalaciones y maquinarias',
            'Trabajadores no calificados',
            'Fuerzas armadas',

        ]),
        'descripcion' => $faker->paragraph(1),
    ];
});

$factory->define(Cargo::class, function (Faker $faker){
    return [
        'nombre' => $faker->jobTitle,
        'descripcion' => $faker->paragraph(1),
    ];
});

$factory->define(Laboral::class, function (Faker $faker){
    return [
        'smn' => $faker->randomFloat(2, 2060, 2060),
        'civ' => $faker->randomFloat(2, 10.00, 10.00),
        'si' => $faker->randomFloat(2, 1.71, 1.71),
        'comision_afp' => $faker->randomFloat(2, 0.50, 0.50),
        'provivienda' => $faker->randomFloat(2, 0.00, 0.00),
        'iva' => $faker->randomFloat(2, 13.00, 13.00),
        'asa' => $faker->randomFloat(2, 0.50, 0.50),
        'ans_13' => $faker->randomFloat(2, 1.00, 1.00),
        'ans_25' => $faker->randomFloat(2, 5.00, 5.00),
        'ans_35' => $faker->randomFloat(2, 10.00, 10.00),
        'cba_1' => $faker->randomFloat(2, 5.00, 5.00),
        'cba_2' => $faker->randomFloat(2, 11.00, 11.00),
        'cba_3' => $faker->randomFloat(2, 18.00, 18.00),
        'cba_4' => $faker->randomFloat(2, 26.00, 26.00),
        'cba_5' => $faker->randomFloat(2, 34.00, 34.00),
        'cba_6' => $faker->randomFloat(2, 42.00, 42.00),
        'cba_7' => $faker->randomFloat(2, 50.00, 50.00),
        'activo' => $faker->numberBetween(1, 1),
        'empresa_id' => Empresa::all()->random()->id,
    ];
});

$factory->define(Patronal::class, function (Faker $faker){
    return [
        'sarp' => $faker->randomFloat(2, 1.71, 1.71),
        'provivienda' => $faker->randomFloat(2, 2.00, 2.00),
        'infocal' => $faker->randomFloat(2, 0.00, 0.00),
        'cnss' => $faker->randomFloat(2, 10.00, 10.00),
        'sip' => $faker->randomFloat(2, 3.00, 3.00),
        'activo' => $faker->numberBetween(1, 1),
        'empresa_id' => Empresa::all()->random()->id,
    ];
});

$factory->define(Empleado::class, function (Faker $faker)
{
   return [
       'tipo_doc' => $faker->randomElement(['1', '2', '3', '4', '5']),
       'nro_doc' => $faker->numberBetween(5123457, 7854126),
       'exp_doc' => $faker->randomElement(['CB', 'LP']),
       'afiliacion' => $faker->randomElement(['1', '2', '3']),
       'nua_cua' => $faker->numberBetween(021542244, 054515454),
       'ap_paterno' => $faker->lastName,
       'ap_materno' => $faker->lastName,
       'nombre' => $faker->name,
       'nacionalidad' => $faker->randomElement(['Bolivia', 'Argentina', 'Venezuela', 'Colombia']),
       'fecha_nacimiento' => $birthDate = $faker->dateTimeThisCentury->format('Y-m-d'),
       'sexo' => $faker->randomElement(['1', '2']),
       'jubilado' => $birthDate <= '1958-01-01'? $faker->randomElement(['1']) : $faker->randomElement(['2']), //+60 años
       'fecha_ingreso' => $birthDate < '2016-01-01'? '2015-01-01' : '2018-08-01', //$faker->date('Y-m-d', 'now'),
       'haber_basico' => $faker->randomFloat(2, 2060, 19440),
       'nro_matricula' => $faker->numberBetween(54515151, 87989564),
       'categoria' => $faker->numberBetween(1, 10),
       'domicilio' => $faker->paragraph(1),
       'obrero' => $faker->randomElement(['1', '2']),
       'empresa_id' => Empresa::all()->random()->id,
       'sucursal_id' => Sucursal::all()->random()->id,
       'contrato_id' => Contrato::all()->random()->id,
       'puesto_id' => Puesto::all()->random()->id,
       'cargo_id' => Cargo::all()->random()->id,
   ];
});

/*$factory->define(Rciva::class, function (Faker $faker){
    return [
        //'sueldo' => $faker->randomFloat(2, 2500, 30000),
        //'empleado_id' => Empleado::all()->random()->id,
        //'periodo_id' => Periodo::all()->random()->id,
    ];
});*/

$factory->define(Hora::class, function (Faker $faker){
    return [
        'empleado_id' => Empleado::all()->random()->id,
        'gestion_id' => Gestion::all()->random()->id,
        'periodo_id' => Periodo::all()->random()->id,
    ];
});

$factory->define(Thora::class, function (Faker $faker){
    return [
        'cantidad' => $faker->numberBetween(1, 10),
        'monto' => $faker->randomFloat(2, 30.12, 260.14),
        'fecha' => $faker->randomElement(['2018-10-01', '2018-10-31']),
        'descripcion' => $faker->paragraph(1),
        'hora_id' => Hora::all()->random()->id,
    ];
});

$factory->define(Domingo::class, function (Faker $faker){
    return [
        'empleado_id' => Empleado::all()->random()->id,
        'gestion_id' => Gestion::all()->random()->id,
        'periodo_id' => Periodo::all()->random()->id,
    ];
});

$factory->define(Tdomingo::class, function (Faker $faker){
    return [
        'cantidad' => $faker->numberBetween(1, 10),
        'monto' => $faker->randomFloat(2, 30.12, 360.14),
        'fecha' => $faker->randomElement(['2018-10-01', '2018-10-31']),
        'descripcion' => $faker->paragraph(1),
        'domingo_id' => Domingo::all()->random()->id,
    ];
});

$factory->define(Bono::class, function (Faker $faker){
    return [
        'empleado_id' => Empleado::all()->random()->id,
        'gestion_id' => Gestion::all()->random()->id,
        'periodo_id' => Periodo::all()->random()->id,
    ];
});

$factory->define(Tbono::class, function (Faker $faker){
    return [
        'monto' => $faker->randomFloat(2, 30.12, 460.14),
        'fecha' => $faker->randomElement(['2018-10-01', '2018-10-30']),
        'descripcion' => $faker->paragraph(1),
        'bono_id' => Bono::all()->random()->id,
    ];
});

$factory->define(Multa::class, function (Faker $faker){
    return [
        'empleado_id' => Empleado::all()->random()->id,
        'gestion_id' => Gestion::all()->random()->id,
        'periodo_id' => Periodo::all()->random()->id,
    ];
});

$factory->define(Tmulta::class, function (Faker $faker){
    return [
        'monto' => $faker->randomFloat(2, 30.12, 560.14),
        'fecha' => $faker->randomElement(['2018-10-01', '2018-10-31']),
        'descripcion' => $faker->paragraph(1),
        'multa_id' => Multa::all()->random()->id,
    ];
});

$factory->define(Descuento::class, function (Faker $faker){
    return [
        'empleado_id' => Empleado::all()->random()->id,
        'gestion_id' => Gestion::all()->random()->id,
        'periodo_id' => Periodo::all()->random()->id,
    ];
});

$factory->define(Tdescuento::class, function (Faker $faker){
    return [
        'monto' => $faker->randomFloat(2, 30.12, 560.14),
        'fecha' => $faker->randomElement(['2018-10-01', '2018-10-31']),
        'descripcion' => $faker->paragraph(1),
        'descuento_id' => Descuento::all()->random()->id,
    ];
});

$factory->define(Category::class, function (Faker $faker){
    return [
        'name' => $faker->word,
        'description' => $faker->paragraph(1),
    ];
});

$factory->define(Product::class, function (Faker $faker){
    return [
        'name' => $faker->word,
        'description' => $faker->paragraph(1),
        'quantity' => $faker->numberBetween(1, 10),
        'status' => $faker->randomElement([Product::AVAILABLE_PRODUCT, Product::UNAVAILABLE_PRODUCT]),
        'image' => $faker->randomElement(['1.jpg', '2.jpg', '3.jpg']),
        'seller_id' => User::all()->random()->id,
    ];
});


$factory->define(Transaction::class, function (Faker $faker){

    $seller = Seller::has('products')->get()->random();
    $buyer = User::all()->except($seller->id)->random();

    return [
        'quantity' => $faker->numberBetween(1, 3),
        'buyer_id' => $buyer->id,
        'product_id' => $seller->products->random()->id,
    ];
});