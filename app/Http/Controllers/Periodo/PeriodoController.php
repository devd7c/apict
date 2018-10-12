<?php

namespace App\Http\Controllers\Periodo;

use App\Periodo;
use App\Regperiodo;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use phpDocumentor\Reflection\Types\String_;

class PeriodoController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $periodos = Periodo::all();
        return $this->showAll($periodos);
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
            'inicio_mes' => 'required',
            'fin_mes' => 'required',
            'gestion_id' => 'required',
        ];

        $this->validate($request, $rules);*/

        $data = $request->all();
        $data['inicio_mes'] = $request->inicio_mes;
        $data['fin_mes'] = $request->fin_mes;
        $data['procesado'] = 2; //$request->procesado;
        $data['cierre'] = 2; //$request->cierre;
        $data['cierre_ufv'] = 0; //$request->cierre_ufv;
        $data['gestion_id'] = $request->gestion_id;

        $periodo = Periodo::create($data);
        return $this->showOne($periodo, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Periodo  $periodo
     * @return \Illuminate\Http\Response
     */
    public function show(Periodo $periodo)
    {
        return $this->showOne($periodo);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Periodo  $periodo
     * @return \Illuminate\Http\Response
     */
    public function edit(Periodo $periodo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Periodo  $periodo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Periodo $periodo)
    {
        /*$rules = [
            'procesado' => 'integer|min:0',
            'cierre' => 'integer|min:0',
            'gestion_id' => 'integer|min:1',
        ];

        $this->validate($request, $rules);*/

        return DB::transaction(function () use ($request, $periodo) {
            $regPeriodos = Regperiodo::all()
                ->where('periodo_id', '=', $periodo->id);

            foreach ($regPeriodos as $regPeriodo) {
                if ($regPeriodo->activo == 1) {
                    $cierreUFV = $regPeriodo->ufv;
                }
            }

            $periodo->fill($request->only([
                'inicio_mes',
                'fin_mes',
                'procesado',
                'cierre',
                //'cierre_ufv',
                'gestion_id',
            ]));
            /*$periodo->inicio_mes = $request->fechaInicio;
            $periodo->fin_mes = $request->fechaFin;
            $periodo->procesado = $request->procesado;
            $periodo->cierre = $request->cierre;*/
            //$periodo->cierre_ufv = $request->cierreUFV;
            //$periodo->gestion_id = $request->idGestion;

            /*if ($periodo->isClean()) {
                return $this->errorResponse('Necesitas ingresar otros valores para actualizar', 422);
            }*/

            $periodo->cierre_ufv = $request->cierre == 1? $cierreUFV : 0;

            $periodo->save();

            //return $this->showOne($periodo);
            return $periodo;
        });
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Periodo  $periodo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Periodo $periodo)
    {
        $periodo->delete();
        return $this->showOne($periodo);
    }

    public function find(Request $request)
    {
        $sortBy[] = $request->input('sort_by');
        $sortOrder[] = $request->input('sort_order');
        $pageSize[] = $request->input('pageSize');

        $idGestion = $request->request->get('id');

        $periodos = DB::table('periodos')
            ->select(
                'periodos.id', 'periodos.gestion_id', 'periodos.inicio_mes', 'periodos.fin_mes', 'periodos.procesado', 'periodos.cierre', 'periodos.cierre_ufv'
            )
            ->where('periodos.deleted_at', '=', null) // Ocultar campos eliminados
            ->where('periodos.gestion_id', '=', $idGestion)
            ->where(DB::raw("concat_ws(' ', periodos.inicio_mes, periodos.fin_mes)"), "LIKE",  '%' . $request["search"] .'%')
            ->orderBy($sortBy[0], $sortOrder[0])
            ->paginate($pageSize[0]);

        // return response()->json(['data' => $empresas, 'code' => 201]);
        return $periodos;
    }
}
