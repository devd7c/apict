<?php

namespace App\Http\Controllers\Bono;

use App\Bono;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use phpDocumentor\Reflection\Types\String_;

class BonoController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bonos = Bono::all();
        return $this->showAll($bonos);
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
        $data = $request->all();
        $data['empleado_id'] = $request->empleado_id;
        $data['gestion_id'] = $request->gestion_id;
        $data['periodo_id'] = $request->periodo_id;


        $bono = Bono::create($data);

        return $this->showOne($bono, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Bono  $bono
     * @return \Illuminate\Http\Response
     */
    public function show(Bono $bono)
    {
        return $this->showOne($bono);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Bono  $bono
     * @return \Illuminate\Http\Response
     */
    public function edit(Bono $bono)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Bono  $bono
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bono $bono)
    {
        return DB::transaction(function () use ($request, $bono) {
            $bono->fill($request->only([
                'empleado_id',
                'gestion_id',
                'periodo_id',
            ]));

            /*if ($bono->isClean()) {
                return $this->errorResponse('Necesitas ingresar otros valores para actualizar', 422);
            }*/
            $bono->save();
            return $this->showOne($bono);
        });
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Bono  $bono
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bono $bono)
    {
        $bono->delete();
        return $this->showOne($bono);
    }

    public function find(Request $request, Response $response)
    {
        $sortBy[] = $request->input('sort_by');
        $sortOrder[] = $request->input('sort_order');
        $pageSize[] = $request->input('pageSize');

        $bonos = DB::table('bonos')
            ->select(
                'bonos.id', 'bonos.empleado_id', 'bonos.gestion_id', 'bonos.periodo_id',
                'empleados.tipo_doc', 'empleados.nro_doc', 'empleados.exp_doc', 'empleados.afiliacion',
                DB::raw('CONCAT(empleados.ap_paterno," ",empleados.ap_materno," ",empleados.nombre) as nombre_completo'),
                'empleados.ap_paterno', 'empleados.ap_materno', 'empleados.ap_casada', 'empleados.nombre',
                'empleados.nua_cua', 'empleados.nacionalidad', 'empleados.fecha_nacimiento',
                'empleados.sexo', 'empleados.jubilado', 'empleados.fecha_ingreso', 'empleados.fecha_retiro',
                'empleados.haber_basico', 'empleados.nro_matricula', 'empleados.categoria', 'empleados.domicilio',
                'empleados.obrero', 'empleados.empresa_id', 'empleados.sucursal_id',
                'empleados.contrato_id', 'empleados.puesto_id', 'empleados.cargo_id',
                'periodos.inicio_mes', 'periodos.fin_mes', 'periodos.procesado', 'periodos.cierre', 'periodos.cierre_ufv',
                'gestions.periodo_inicio', 'gestions.periodo_rango', 'gestions.activo',
                DB::raw("(SELECT sum(t.monto) FROM tbonos t WHERE t.bono_id=bonos.id AND t.deleted_at IS NULL) AS monto_total")
            )
            ->join('empleados','empleados.id','=','bonos.empleado_id')
            ->join('periodos', 'periodos.id', '=', 'bonos.periodo_id')
            ->join('gestions', 'gestions.id', '=', 'bonos.gestion_id')
            ->groupBy('bonos.id')
            ->where('bonos.deleted_at', '=', null) // Ocultar campos eliminados
            ->where(DB::raw('CONCAT(empleados.ap_paterno," ",empleados.ap_materno," ",empleados.nombre, " ",gestions.periodo_inicio)'), 'like',  '%' . $request['search'] .'%')
            ->where(function ($query) use ($request) {
                if ($request['empresa'] != null) {
                    $query->where('gestions.empresa_id', '=', $request['empresa']);
                }
                if ($request['gestion'] != null) {
                    $query->where('bonos.gestion_id', '=', $request['gestion']);
                }
                if ($request['periodo'] != null) {
                    $query->where('bonos.periodo_id', '=', $request['periodo']);
                }
            })
            ->orderBy($sortBy[0], $sortOrder[0])
            ->paginate($pageSize[0]);

        /*$bonos = DB::table('bonos')
            ->select(
                'bonos.id', 'bonos.empleado_id', 'bonos.gestion_id', 'bonos.periodo_id',
                'empleados.nombre','empleados.tipo_doc', 'empleados.nro_doc', 'empleados.exp_doc',
                'empleados.afiliacion', 'empleados.nua_cua', 'empleados.ap_paterno', 'empleados.ap_materno',
                'empleados.ap_casada', 'empleados.nombre', 'empleados.nacionalidad', 'empleados.fecha_nacimiento',
                'empleados.sexo', 'empleados.jubilado', 'empleados.fecha_ingreso', 'empleados.fecha_retiro',
                'empleados.haber_basico', 'empleados.nro_matricula', 'empleados.categoria', 'empleados.domicilio',
                'empleados.obrero', 'empleados.empresa_id', 'empleados.sucursal_id',
                'empleados.contrato_id', 'empleados.puesto_id', 'empleados.cargo_id',
                'periodos.inicio_mes', 'periodos.fin_mes', 'periodos.procesado', 'periodos.cierre', 'periodos.cierre_ufv',
                'gestions.periodo_inicio', 'gestions.periodo_rango', 'gestions.activo',
                DB::raw("(SELECT sum(t.monto) FROM tbonos t WHERE t.bono_id=bonos.id) AS monto_total")
            )
            ->join('empleados','empleados.id','=','bonos.empleado_id')
            ->join('periodos', 'periodos.id', '=', 'bonos.periodo_id')
            ->join('gestions', 'gestions.id', '=', 'bonos.gestion_id')
            ->groupBy('bonos.id')
            ->where('bonos.deleted_at', '=', null) // Ocultar campos eliminados
            //->orderBy('id', 'asc')
            ->paginate(15);*/

        return $bonos;
    }
}
