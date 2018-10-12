<?php

namespace App\Http\Controllers\Gestion;

use App\Gestion;
use App\Periodo;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use phpDocumentor\Reflection\Types\String_;

class GestionController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $gestiones = Gestion::all();
        return $this->showAll($gestiones);
        /*$result = Gestion::paginate(30);
        return $result;*/
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
            'periodo_inicio' => 'required',
            'activo' => 'required',
            'empresa_id' => 'required',
        ];

        $this->validate($request, $rules);*/

        return DB::transaction(function () use ($request) {
            $gestion = Gestion::create([
                'periodo_inicio' => $request->periodo_inicio,
                'periodo_rango' => $request->periodo_rango,
                'activo' => 1,//$request->activo,
                'empresa_id' => $request->empresa_id,
            ]);

            $fecha = $gestion->periodo_inicio.'-01-01';
            $mes = strtotime($fecha);
            for ($i = 0; $i < 12; $i++) {
                $periodos = [
                    'inicio_mes' => date('Y-m-d', $mes),
                    'fin_mes' => date('Y-m-t', $mes),
                    'gestion_id' => $gestion->id,
                ];
                $mes = strtotime('+1 month', $mes);
                Periodo::create($periodos);
            }

            return $this->showOne($gestion, 201);
        });
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Gestion  $gestion
     * @return \Illuminate\Http\Response
     */
    public function show(Gestion $gestion)
    {
        return $this->showOne($gestion);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Gestion  $gestion
     * @return \Illuminate\Http\Response
     */
    public function edit(Gestion $gestion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Gestion  $gestion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Gestion $gestion)
    {
        /*$gestion->periodo_inicio = $request->periodo_inicio;
        $gestion->periodo_rango = $request->periodo_rango;
        $gestion->activo = $request->activo;
        $gestion->empresa_id = $request->empresa_id;*/

        /*if ($gestion->isClean()) {
            return $this->errorResponse('Necesitas ingresar otros valores para actualizar', 422);
        }*/

        $gestion->fill($request->only([
            'periodo_inicio',
            'periodo_rango',
            'activo',
            'empresa_id',
        ]));

        $gestion->save();
        return $this->showOne($gestion);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Gestion  $gestion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Gestion $gestion)
    {
        $gestion->delete();
        return $this->showOne($gestion);
    }

    public function find(Request $request)
    {
        $sortBy[] = $request->input('sort_by');
        $sortOrder[] = $request->input('sort_order');
        $pageSize[] = $request->input('pageSize');

        $idEmpresa = $request->request->get('state');

        $gestions = DB::table('gestions')
            ->select(
                'gestions.id', 'gestions.periodo_inicio', 'gestions.periodo_rango', 'gestions.activo'
            )
            ->where('gestions.deleted_at', '=', null) // Ocultar campos eliminados
            ->where('gestions.empresa_id', '=', $idEmpresa['entityId'])
            ->where(DB::raw("CONCAT(gestions.periodo_inicio,' ',gestions.periodo_rango)"), "LIKE",  "%" . $request["search"] ."%")
            ->orderBy($sortBy[0], $sortOrder[0])
            ->paginate($pageSize[0]);

        // return response()->json(['data' => $empresas, 'code' => 201]);
        return $gestions;

        /*$data = $request->request->get('state');
        $result = Gestion::all()
            ->where('empresa_id', '=', $data['entityId']);
        return $this->showAll($result);*/
    }
}
