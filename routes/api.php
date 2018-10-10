<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/**
 * EMPRESAS
 */
Route::resource('empresas', 'Empresa\EmpresaController');
Route::resource('empresas.sucursals', 'Empresa\EmpresaSucursalController');
Route::resource('empresas.gestions', 'Empresa\EmpresaGestionController');
Route::resource('empresas.laborals', 'Empresa\EmpresaLaboralController');
Route::resource('empresas.patronals', 'Empresa\EmpresaPatronalController');
Route::name('find')->get('empresas/find/{tmulta}', 'Empresa\EmpresaController@find');

/**
 * SUCURSALES
 */
Route::resource('sucursals', 'Sucursal\SucursalController');
Route::name('find')->post('sucursals/find/{sucursal}', 'Sucursal\SucursalController@find');

/**
 * GESTIONES
 */
Route::resource('gestions', 'Gestion\GestionController');
Route::resource('gestions.periodos', 'Gestion\GestionPeriodoController');
Route::name('find')->post('gestions/find/{gestion}', 'Gestion\GestionController@find');

/**
 * PERIODOS
 */
Route::resource('periodos', 'Periodo\PeriodoController');
Route::resource('periodos.regperiodos', 'Periodo\PeriodoRegperiodoController');
Route::name('find')->post('periodos/find/{periodo}', 'Periodo\PeriodoController@find');

/**
 * REGISTRO PERIODOS
 */
Route::resource('regperiodos', 'Regperiodo\RegperiodoController');
Route::name('find')->get('regperiodos/find/{filter}', 'Regperiodo\RegperiodoController@find');

/**
 * APORTES LABORALES
 */
Route::resource('laborals', 'Laboral\LaboralController');
Route::name('find')->post('laborals/find/{laboral}', 'Laboral\LaboralController@find');
Route::name('getactive')->get('laborals/{empresa}/getactive', 'Laboral\LaboralController@getactive');

/**
 * APORTES PATRONALES
 */
Route::resource('patronals', 'Patronal\PatronalController');
Route::name('find')->post('patronals/find/{patronal}', 'Patronal\PatronalController@find');
Route::name('getactive')->get('patronals/{empresa}/getactive', 'Patronal\PatronalController@getactive');

/**
 * DEPENDIENTES
 */
Route::resource('empleados', 'Empleado\EmpleadoController');
Route::name('find')->get('empleados/find/{filter}', 'Empleado\EmpleadoController@find');


/**
 * MULTAS
 */
Route::resource('multas', 'Multa\MultaController');
Route::resource('multas.tmultas', 'Multa\MultaTmultaController');
Route::name('find')->get('multas/find/{multa}', 'Multa\MultaController@find');

/**
 * TOTAL MULTAS
 */
Route::resource('tmultas', 'Tmulta\TmultaController');
Route::name('find')->post('tmultas/find/{tmulta}', 'Tmulta\TmultaController@find');

/**
 * DESCUENTOS
 */
Route::resource('descuentos', 'Descuento\DescuentoController');
Route::resource('descuentos.tdescuentos', 'Descuento\DescuentoTdescuentoController');
Route::name('find')->get('descuentos/find/{descuento}', 'Descuento\DescuentoController@find');

/**
 * TOTAL DESCUENTOS
 */
Route::resource('tdescuentos', 'Tdescuento\TdescuentoController');
Route::name('find')->post('tdescuentos/find/{tdescuento}', 'Tdescuento\TdescuentoController@find');

/**
 * HORAS EXTRA
 */
Route::resource('horas', 'Hora\HoraController');
Route::resource('horas.thoras', 'Hora\HoraThoraController');
Route::name('find')->get('horas/find/{hora}', 'Hora\HoraController@find');

/**
 * TOTAL HORAS EXTRA
 */
Route::resource('thoras', 'Thora\ThoraController');
Route::name('find')->post('thoras/find/{thora}', 'Thora\ThoraController@find');

/**
 * DOMINGOS FERIADOS
 */
Route::resource('domingos', 'Domingo\DomingoController');
Route::resource('domingos.tdomingos', 'Domingo\DomingoTdomingoController');
Route::name('find')->get('domingos/find/{domingo}', 'Domingo\DomingoController@find');

/**
 * TOTAL DOMINGOS FERIADOS
 */
Route::resource('tdomingos', 'Tdomingo\TdomingoController');
Route::name('find')->post('tdomingos/find/{tdomingo}', 'Tdomingo\TdomingoController@find');

/**
 * BONOS
 */
Route::resource('bonos', 'Bono\BonoController');
Route::resource('bonos.tbonos', 'Bono\BonoTbonoController');
Route::name('find')->get('bonos/find/{bono}', 'Bono\BonoController@find');

/**
 * TOTAL BONOS
 */
Route::resource('tbonos', 'Tbono\TbonoController');
Route::name('find')->post('tbonos/find/{tbono}', 'Tbono\TbonoController@find');


/**
 * CONTRATOS
 */
Route::resource('contratos', 'Contrato\ContratoController');

/**
 * PUESTOS
 */
Route::resource('puestos', 'Puesto\PuestoController');

/**
 * CARGOS
 */
Route::resource('cargos', 'Cargo\CargoController');

/**
 * FORMULARIOS 110
 */
Route::resource('rcivas', 'Rciva\RcivaController');
Route::name('find')->get('rcivas/find/{rciva}', 'Rciva\RcivaController@find');

/**
 * PROCESOS
 */
Route::resource('procesos', 'Proceso\ProcesoController');
Route::name('find')->get('procesos/find/{proceso}', 'Proceso\ProcesoController@find');

/**
 * PROCESOS SUELDOS
 */
Route::resource('psueldos', 'Psueldo\PsueldoController');
Route::name('find')->get('psueldos/find/{psueldo}', 'Psueldo\PsueldoController@find');

/**
 * PROCESOS AFILIADOS -> PREVISION -> FUTURO
 */
Route::resource('pafiliados', 'Pafiliado\PafiliadoController');
Route::name('find')->get('pafiliados/find/{pafiliado}', 'Pafiliado\PafiliadoController@find');

/**
 * Buyers
 */
Route::resource('buyers', 'Buyer\BuyerController', ['only' => ['index', 'show']]);
Route::resource('buyers.transactions', 'Buyer\BuyerTransactionController', ['only' => ['index']]);
Route::resource('buyers.products', 'Buyer\BuyerProductController', ['only' => ['index']]);
Route::resource('buyers.sellers', 'Buyer\BuyerSellerController', ['only' => ['index']]);
Route::resource('buyers.categories', 'Buyer\BuyerCategoryController', ['only' => ['index']]);

/**
 * Categories
 */
Route::resource('categories', 'Category\CategoryController', ['except' => ['created', 'edit']]);
Route::resource('categories.buyers', 'Category\CategoryBuyerController', ['only' => ['index']]);
Route::resource('categories.sellers', 'Category\CategorySellerController', ['only' => ['index']]);
Route::resource('categories.products', 'Category\CategoryProductController', ['only' => ['index']]);
Route::resource('categories.transactions', 'Category\CategoryTransactionController', ['only' => ['index']]);


/**
 * Products
 */
Route::resource('products', 'Product\ProductController', ['only' => ['index', 'show']]);
Route::resource('products.transactions', 'Product\ProductTransactionController', ['only' => ['index']]);
Route::resource('products.buyers', 'Product\ProductBuyerController', ['only' => ['index']]);
Route::resource('products.categories', 'Product\ProductCategoryController', ['only' => ['index', 'update', 'destroy']]);
Route::resource('products.buyers.transactions', 'Product\ProductBuyerTransactionController', ['only' => ['store']]);

/**
 * Sellers
 */
Route::resource('sellers', 'Seller\SellerController', ['only' => ['index', 'show']]);
Route::resource('sellers.transactions', 'Seller\SellerTransactionController', ['only' => ['index']]);
Route::resource('sellers.categories', 'Seller\SellerCategoryController', ['only' => ['index']]);
Route::resource('sellers.buyers', 'Seller\SellerBuyerController', ['only' => ['index']]);
Route::resource('sellers.products', 'Seller\SellerProductController', ['except' => ['created', 'show', 'edit']]);

/**
 * Transactions
 */
Route::resource('transactions', 'Transaction\TransactionController', ['only' => ['index', 'show']]);
Route::resource('transactions.categories', 'Transaction\TransactionCategoryController', ['only' => ['index']]);
Route::resource('transactions.sellers', 'Transaction\TransactionSellerController', ['only' => ['index']]);

/**
 * Users
 */
Route::resource('users', 'User\UserController', ['except' => ['created', 'edit']]);
Route::name('verify')->get('users/verify/{token}', 'User\UserController@verify');
Route::name('resend')->get('users/{user}/resend', 'User\UserController@resend');
