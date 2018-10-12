<?php

namespace App\Http\Controllers\Multa;

use App\Multa;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use function MongoDB\BSON\toJSON;
use phpDocumentor\Reflection\Types\String_;

class MultaController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $multas = Multa::all();
        return $this->showAll($multas);
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


        $multa = Multa::create($data);

        return $this->showOne($multa, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Multa  $multa
     * @return \Illuminate\Http\Response
     */
    public function show(Multa $multa)
    {
        return $this->showOne($multa);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Multa  $multa
     * @return \Illuminate\Http\Response
     */
    public function edit(Multa $multa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Multa  $multa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Multa $multa)
    {
        return DB::transaction(function () use ($request, $multa) {
            $multa->fill($request->only([
                'empleado_id',
                'gestion_id',
                'periodo_id',
            ]));

            /*if ($multa->isClean()) {
                return $this->errorResponse('Necesitas ingresar otros valores para actualizar', 422);
            }*/
            $multa->save();
            return $this->showOne($multa);
        });
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Multa  $multa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Multa $multa)
    {
        $multa->delete();
        return $this->showOne($multa);
    }

    public function find(Request $request, Response $response)
    {
        $sortBy[] = $request->input('sort_by');
        $sortOrder[] = $request->input('sort_order');
        $pageSize[] = $request->input('pageSize');
        // $request['sexo'];

        $multas = DB::table('multas')
            ->select(
                'multas.id', 'multas.empleado_id', 'multas.gestion_id', 'multas.periodo_id',
                'empleados.tipo_doc', 'empleados.nro_doc', 'empleados.exp_doc', 'empleados.afiliacion',
                DB::raw("CONCAT(empleados.ap_paterno,' ',empleados.ap_materno,' ',empleados.nombre) AS nombre_completo"),
                'empleados.ap_paterno', 'empleados.ap_materno', 'empleados.ap_casada', 'empleados.nombre',
                'empleados.nua_cua', 'empleados.nacionalidad', 'empleados.fecha_nacimiento',
                'empleados.sexo', 'empleados.jubilado', 'empleados.fecha_ingreso', 'empleados.fecha_retiro',
                'empleados.haber_basico', 'empleados.nro_matricula', 'empleados.categoria', 'empleados.domicilio',
                'empleados.obrero', 'empleados.empresa_id', 'empleados.sucursal_id',
                'empleados.contrato_id', 'empleados.puesto_id', 'empleados.cargo_id',
                'periodos.inicio_mes', 'periodos.fin_mes', 'periodos.procesado', 'periodos.cierre', 'periodos.cierre_ufv',
                'gestions.periodo_inicio', 'gestions.periodo_rango', 'gestions.activo',
                DB::raw("(SELECT sum(t.monto) FROM tmultas t WHERE t.multa_id=multas.id AND t.deleted_at IS NULL) AS monto_total")
            )
            ->join('empleados','empleados.id','=','multas.empleado_id')
            ->join('periodos', 'periodos.id', '=', 'multas.periodo_id')
            ->join('gestions', 'gestions.id', '=', 'multas.gestion_id')
            // ->groupBy('multas.id')
            ->where('multas.deleted_at', '=', null) // Ocultar campos eliminados
            ->where(DB::raw("concat_ws(' ', empleados.ap_paterno, empleados.ap_materno, empleados.nombre, gestions.periodo_inicio)"), 'LIKE',  '%' . $request["search"] .'%')
            ->where(function ($query) use ($request) {
                if ($request['empresa'] != null) {
                    $query->where('gestions.empresa_id', '=', $request["empresa"]);
                }
                if ($request['gestion'] != null) {
                    $query->where('multas.gestion_id', '=', $request["gestion"]);
                }
                if ($request['periodo'] != null) {
                    $query->where('multas.periodo_id', '=', $request["periodo"]);
                }
            })
            ->orderBy($sortBy[0], $sortOrder[0])
            ->paginate($pageSize[0]);

        /*$multas = DB::table('multas')
            ->select(
                'multas.id', 'multas.empleado_id', 'multas.gestion_id', 'multas.periodo_id',
                'empleados.nombre','empleados.tipo_doc', 'empleados.nro_doc', 'empleados.exp_doc',
                'empleados.afiliacion', 'empleados.nua_cua', 'empleados.ap_paterno', 'empleados.ap_materno',
                'empleados.ap_casada', 'empleados.nombre', 'empleados.nacionalidad', 'empleados.fecha_nacimiento',
                'empleados.sexo', 'empleados.jubilado', 'empleados.fecha_ingreso', 'empleados.fecha_retiro',
                'empleados.haber_basico', 'empleados.nro_matricula', 'empleados.categoria', 'empleados.domicilio',
                'empleados.obrero', 'empleados.empresa_id', 'empleados.sucursal_id',
                'empleados.contrato_id', 'empleados.puesto_id', 'empleados.cargo_id',
                'periodos.inicio_mes', 'periodos.fin_mes', 'periodos.procesado', 'periodos.cierre', 'periodos.cierre_ufv',
                'gestions.periodo_inicio', 'gestions.periodo_rango', 'gestions.activo',
                DB::raw("(SELECT sum(t.monto) FROM tmultas t WHERE t.multa_id=multas.id) AS monto_total")
            )
            ->join('empleados','empleados.id','=','multas.empleado_id')
            ->join('periodos', 'periodos.id', '=', 'multas.periodo_id')
            ->join('gestions', 'gestions.id', '=', 'multas.gestion_id')
            ->groupBy('multas.id')
            ->where('multas.deleted_at', '=', null) // Ocultar campos eliminados
            //->orderBy('id', 'asc')
            ->paginate(15);*/

        //$result = $request->all();

        //dd($result);
        /*$result = $request['sexo'];
        return response()->json(['data' => $result, 'code' => 201]);*/
        return $multas;
    }
}
