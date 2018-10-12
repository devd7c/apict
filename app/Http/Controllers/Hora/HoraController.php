<?php

namespace App\Http\Controllers\Hora;

use App\Hora;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use phpDocumentor\Reflection\Types\String_;

class HoraController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $horas = Hora::all();
        return $this->showAll($horas);
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


        $hora = Hora::create($data);

        return $this->showOne($hora, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Hora  $hora
     * @return \Illuminate\Http\Response
     */
    public function show(Hora $hora)
    {
        return $this->showOne($hora);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Hora  $hora
     * @return \Illuminate\Http\Response
     */
    public function edit(Hora $hora)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Hora  $hora
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Hora $hora)
    {
        return DB::transaction(function () use ($request, $hora) {
            $hora->fill($request->only([
                'empleado_id',
                'gestion_id',
                'periodo_id',
            ]));

            /*if ($hora->isClean()) {
                return $this->errorResponse('Necesitas ingresar otros valores para actualizar', 422);
            }*/
            $hora->save();
            return $this->showOne($hora);
        });
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Hora  $hora
     * @return \Illuminate\Http\Response
     */
    public function destroy(Hora $hora)
    {
        $hora->delete();
        return $this->showOne($hora);
    }

    public function find(Request $request, Response $response)
    {
        $sortBy[] = $request->input('sort_by');
        $sortOrder[] = $request->input('sort_order');
        $pageSize[] = $request->input('pageSize');

        $horas = DB::table('horas')
            ->select(
                'horas.id', 'horas.empleado_id', 'horas.gestion_id', 'horas.periodo_id',
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
                DB::raw("(SELECT sum(t.monto) FROM thoras t WHERE t.hora_id=horas.id AND t.deleted_at IS NULL) AS monto_total")
            )
            ->join('empleados','empleados.id','=','horas.empleado_id')
            ->join('periodos', 'periodos.id', '=', 'horas.periodo_id')
            ->join('gestions', 'gestions.id', '=', 'horas.gestion_id')
            ->groupBy('horas.id')
            ->where('horas.deleted_at', '=', null) // Ocultar campos eliminados
            ->where(DB::raw("CONCAT(empleados.ap_paterno,' ',empleados.ap_materno,' ',empleados.nombre,' ',gestions.periodo_inicio)"), "LIKE",  "%" . $request["search"] ."%")
            ->where(function ($query) use ($request) {
                if ($request['empresa'] != null) {
                    $query->where('gestions.empresa_id', '=', $request['empresa']);
                }
                if ($request['gestion'] != null) {
                    $query->where('horas.gestion_id', '=', $request['gestion']);
                }
                if ($request['periodo'] != null) {
                    $query->where('horas.periodo_id', '=', $request['periodo']);
                }
            })
            ->orderBy($sortBy[0], $sortOrder[0])
            ->paginate($pageSize[0]);

        /*$horas = DB::table('horas')
            ->select(
                'horas.id', 'horas.empleado_id', 'horas.gestion_id', 'horas.periodo_id',
                'empleados.nombre','empleados.tipo_doc', 'empleados.nro_doc', 'empleados.exp_doc',
                'empleados.afiliacion', 'empleados.nua_cua', 'empleados.ap_paterno', 'empleados.ap_materno',
                'empleados.ap_casada', 'empleados.nombre', 'empleados.nacionalidad', 'empleados.fecha_nacimiento',
                'empleados.sexo', 'empleados.jubilado', 'empleados.fecha_ingreso', 'empleados.fecha_retiro',
                'empleados.haber_basico', 'empleados.nro_matricula', 'empleados.categoria', 'empleados.domicilio',
                'empleados.obrero', 'empleados.empresa_id', 'empleados.sucursal_id',
                'empleados.contrato_id', 'empleados.puesto_id', 'empleados.cargo_id',
                'periodos.inicio_mes', 'periodos.fin_mes', 'periodos.procesado', 'periodos.cierre', 'periodos.cierre_ufv',
                'gestions.periodo_inicio', 'gestions.periodo_rango', 'gestions.activo',
                DB::raw("(SELECT sum(t.monto) FROM thoras t WHERE t.hora_id=horas.id) AS monto_total")
            )
            ->join('empleados','empleados.id','=','horas.empleado_id')
            ->join('periodos', 'periodos.id', '=', 'horas.periodo_id')
            ->join('gestions', 'gestions.id', '=', 'horas.gestion_id')
            ->groupBy('horas.id')
            ->where('horas.deleted_at', '=', null) // Ocultar campos eliminados
            //->orderBy('id', 'asc')
            ->paginate(15);*/

        return $horas;
    }
}
