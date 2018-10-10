<?php

namespace App\Http\Controllers\Domingo;

use App\Domingo;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use phpDocumentor\Reflection\Types\String_;

class DomingoController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $domingos = Domingo::all();
        return $this->showAll($domingos);
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


        $domingo = Domingo::create($data);

        return $this->showOne($domingo, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Domingo  $domingo
     * @return \Illuminate\Http\Response
     */
    public function show(Domingo $domingo)
    {
        return $this->showOne($domingo);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Domingo  $domingo
     * @return \Illuminate\Http\Response
     */
    public function edit(Domingo $domingo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Domingo  $domingo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Domingo $domingo)
    {
        return DB::transaction(function () use ($request, $domingo) {
            $domingo->fill($request->only([
                'empleado_id',
                'gestion_id',
                'periodo_id',
            ]));

            /*if ($domingo->isClean()) {
                return $this->errorResponse('Necesitas ingresar otros valores para actualizar', 422);
            }*/
            $domingo->save();
            return $this->showOne($domingo);
        });
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Domingo  $domingo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Domingo $domingo)
    {
        $domingo->delete();
        return $this->showOne($domingo);
    }

    public function find(Request $request, Response $response)
    {
        $sortBy[] = $request->input('sort_by');
        $sortOrder[] = $request->input('sort_order');
        $pageSize[] = $request->input('pageSize');

        $domingos = DB::table('domingos')
            ->select(
                'domingos.id', 'domingos.empleado_id', 'domingos.gestion_id', 'domingos.periodo_id',
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
                DB::raw("(SELECT sum(t.monto) FROM tdomingos t WHERE t.domingo_id=domingos.id AND t.deleted_at IS NULL) AS monto_total")
            )
            ->join('empleados','empleados.id','=','domingos.empleado_id')
            ->join('periodos', 'periodos.id', '=', 'domingos.periodo_id')
            ->join('gestions', 'gestions.id', '=', 'domingos.gestion_id')
            ->groupBy('domingos.id')
            ->where('domingos.deleted_at', '=', null) // Ocultar campos eliminados
            ->where(DB::raw('CONCAT(empleados.ap_paterno," ",empleados.ap_materno," ",empleados.nombre, " ",gestions.periodo_inicio)'), 'like',  '%' . $request['search'] .'%')
            ->where(function ($query) use ($request) {
                if ($request['empresa'] != null) {
                    $query->where('gestions.empresa_id', '=', $request['empresa']);
                }
                if ($request['gestion'] != null) {
                    $query->where('domingos.gestion_id', '=', $request['gestion']);
                }
                if ($request['periodo'] != null) {
                    $query->where('domingos.periodo_id', '=', $request['periodo']);
                }
            })
            ->orderBy($sortBy[0], $sortOrder[0])
            ->paginate($pageSize[0]);

        /*$domingos = DB::table('domingos')
            ->select(
                'domingos.id', 'domingos.empleado_id', 'domingos.gestion_id', 'domingos.periodo_id',
                'empleados.nombre','empleados.tipo_doc', 'empleados.nro_doc', 'empleados.exp_doc',
                'empleados.afiliacion', 'empleados.nua_cua', 'empleados.ap_paterno', 'empleados.ap_materno',
                'empleados.ap_casada', 'empleados.nombre', 'empleados.nacionalidad', 'empleados.fecha_nacimiento',
                'empleados.sexo', 'empleados.jubilado', 'empleados.fecha_ingreso', 'empleados.fecha_retiro',
                'empleados.haber_basico', 'empleados.nro_matricula', 'empleados.categoria', 'empleados.domicilio',
                'empleados.obrero', 'empleados.empresa_id', 'empleados.sucursal_id',
                'empleados.contrato_id', 'empleados.puesto_id', 'empleados.cargo_id',
                'periodos.inicio_mes', 'periodos.fin_mes', 'periodos.procesado', 'periodos.cierre', 'periodos.cierre_ufv',
                'gestions.periodo_inicio', 'gestions.periodo_rango', 'gestions.activo',
                DB::raw("(SELECT sum(t.monto) FROM tdomingos t WHERE t.domingo_id=domingos.id) AS monto_total")
            )
            ->join('empleados','empleados.id','=','domingos.empleado_id')
            ->join('periodos', 'periodos.id', '=', 'domingos.periodo_id')
            ->join('gestions', 'gestions.id', '=', 'domingos.gestion_id')
            ->groupBy('domingos.id')
            ->where('domingos.deleted_at', '=', null) // Ocultar campos eliminados
            //->orderBy('id', 'asc')
            ->paginate(15);*/

        return $domingos;
    }
}
