<?php

namespace App\Http\Controllers\Laboral;

use App\Empresa;
use App\Laboral;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use phpDocumentor\Reflection\Types\String_;

class LaboralController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $laborals = Laboral::all();
        return $this->showAll($laborals);
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
        /*$rules = [
            'smn' => 'required',
            'civ' => 'required',
            'si' => 'required',
            'comision_afp' => 'required',
            'provivienda' => 'required',
            'iva' => 'required',
            'asa' => 'required',
            'ans_13' => 'required',
            'ans_25' => 'required',
            'ans_35' => 'required',
            'cba_1' => 'required',
            'cba_2' => 'required',
            'cba_3' => 'required',
            'cba_4' => 'required',
            'cba_basico' => 'required',
            'activo' => 'required',
        ];

        $this->validate($request, $rules);*/

        return DB::transaction(function () use ($request) {
            $update = Laboral::all()
                ->where('activo', '=', 1)
                ->where('empresa_id', '=', $request->empresa_id)
                ->first();

            if ($update) {
                $update->activo = 2;
                $update->save();
            }

            $insert = Laboral::create($request->all());

            return $this->showOne($insert, 201);
            //return $aporteLaboral->activo;
        });
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Laboral  $laboral
     * @return \Illuminate\Http\Response
     */
    public function show(Laboral $laboral)
    {
        return $this->showOne($laboral);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Laboral  $laboral
     * @return \Illuminate\Http\Response
     */
    public function edit(Laboral $laboral)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Laboral  $laboral
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Laboral $laboral)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Laboral  $laboral
     * @return \Illuminate\Http\Response
     */
    public function destroy(Laboral $laboral)
    {
        $laboral->delete();
        return $this->showOne($laboral);
    }

    public function find(Request $request, Response $response)
    {
        $sortBy[] = $request->input('sort_by');
        $sortOrder[] = $request->input('sort_order');
        $pageSize[] = $request->input('pageSize');

        $idEmpresa = $request->request->get('state');

        $laborals = DB::table('laborals')
            ->select(
                'laborals.id', 'laborals.empresa_id', 'laborals.smn', 'laborals.civ', 'laborals.si', 'laborals.comision_afp',
                'laborals.provivienda', 'laborals.iva', 'laborals.asa', 'laborals.ans_13', 'laborals.ans_25',
                'laborals.ans_35', 'laborals.cba_1', 'laborals.cba_2', 'laborals.cba_3', 'laborals.cba_4',
                'laborals.cba_5', 'laborals.cba_6', 'laborals.cba_7', 'laborals.activo'

            )
            ->where('laborals.deleted_at', '=', null) // Ocultar campos eliminados
            ->where('laborals.empresa_id', '=', $idEmpresa['entityId'])
            ->where(DB::raw('CONCAT(laborals.smn," ",laborals.activo)'), 'like',  '%' . $request['search'] .'%')
            ->orderBy($sortBy[0], $sortOrder[0])
            ->paginate($pageSize[0]);

        // return response()->json(['data' => $empresas, 'code' => 201]);
        return $laborals;

    }
    public function getactive(Empresa $empresa) {
        $laborals = $empresa->laborals()
            ->where('empresa_id', '=', $empresa->id)
            ->where('activo', '=', 1)->first();
        //return response()->json(['data' => $laborals, 'code' => 201]);
        return $this->showOne($laborals);
    }
}
