<?php

namespace App\Http\Controllers\Proceso;

use App\Empleado;
use App\Http\Controllers\Rciva\RcivaController;
use App\Laboral;
use App\Patronal;
use App\Proceso;
use App\Regperiodo;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use function MongoDB\BSON\toJSON;
use phpDocumentor\Reflection\Types\String_;

class ProcesoController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $procesos = Proceso::all();
        return $this->showAll($procesos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return DB::transaction(function () use ($request) {

            $laboral = Laboral::where('empresa_id', '=', $request->empresa_id)
                ->where('activo', 1)
                ->first();

            $patronal = Patronal::where('empresa_id', '=', $request->empresa_id)
                ->where('activo', 1)
                ->first();

            $regperiodo = Regperiodo::where('periodo_id', '=', $request->periodo_id)
                ->where('activo', 1)
                ->first();


            if (RcivaController::ifActualPeriodo($request->empresa_id, $request->gestion_id, $request->periodo_id) == true && $regperiodo != null) {

                $data = $request->all();
                $data['empresa_id'] = $request->empresa_id;
                $data['gestion_id'] = $request->gestion_id;
                $data['periodo_id'] = $request->periodo_id;
                $data['regperiodo_id'] = $regperiodo->id;
                $data['patronal_id'] = $patronal->id;
                $data['laboral_id'] = $laboral->id;

                $dependientes = Empleado::all()
                    ->where('empresa_id', '=', $request->empresa_id);

                // $proceso = Proceso::create($data);


                return response()->json(['data' => $data, 'code' => 211]);

            } else {
                return response()->json(['data' => 'No es el periodo actual', 'code' => 211]);
            }

            /*Laboral::create([
                'smn' => 2060,
                'civ' => 10.00,
                'si' => 1.71,
                'comision_afp' => 0.50,
                'provivienda' => 0.00,
                'iva' => 13.00,
                'asa' => 0.50,
                'ans_13' => 1.00,
                'ans_25' => 5.00,
                'ans_35' => 10.00,
                'cba_1' => 5.00,
                'cba_2' => 11.00,
                'cba_3' => 18.00,
                'cba_4' => 26.00,
                'cba_5' => 34.00,
                'cba_6' => 42.00,
                'cba_7' => 50.00,
                'activo' => 1,
                'empresa_id' => $empresa->id,
            ]);

            Patronal::create([
                'sarp' => 1.71,
                'provivienda' => 2.00,
                'infocal' => 0.00,
                'cnss' => 10.00,
                'sip' => 3.00,
                'activo' => 1,
                'empresa_id' => $empresa->id,
            ]);*/

            //return $this->showOne($proceso, 201);
        });
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Proceso  $proceso
     * @return \Illuminate\Http\Response
     */
    public function show(Proceso $proceso)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Proceso  $proceso
     * @return \Illuminate\Http\Response
     */
    public function edit(Proceso $proceso)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Proceso  $proceso
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Proceso $proceso)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Proceso  $proceso
     * @return \Illuminate\Http\Response
     */
    public function destroy(Proceso $proceso)
    {
        $proceso->delete();
        return $this->showOne($proceso);
    }
}
