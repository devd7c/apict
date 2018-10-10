<?php

namespace App\Http\Controllers\Regperiodo;

use App\Regperiodo;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use function MongoDB\BSON\toJSON;
use phpDocumentor\Reflection\Types\String_;

class RegperiodoController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $regperiodos = Regperiodo::all();
        return $this->showAll($regperiodos);
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

            $update = Regperiodo::all()
                ->where('activo', '=', 1)
                ->where('periodo_id', '=', $request->periodo_id)
                ->first();

            if ($update) {
                $update->activo = 2;
                $update->save();
            }

            $data = $request->all();
            $data['fecha'] = $request->fecha;
            $data['tipo_cambio'] = $request->tipo_cambio;
            $data['ufv'] = $request->ufv;
            $data['activo'] = $request->activo;
            $data['periodo_id'] = $request->periodo_id;

            $regperiodo = Regperiodo::create($data);

            return $this->showOne($regperiodo, 201);
        });
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Regperiodo  $regperiodo
     * @return \Illuminate\Http\Response
     */
    public function show(Regperiodo $regperiodo)
    {
        return $this->showOne($regperiodo);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Regperiodo  $regperiodo
     * @return \Illuminate\Http\Response
     */
    public function edit(Regperiodo $regperiodo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Regperiodo  $regperiodo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Regperiodo $regperiodo)
    {
        $regperiodo->fill($request->only([
            'fecha',
            'tipo_cambio',
            'ufv',
            'activo',
            'periodo_id',
        ]));

        /*if ($regperiodo->isClean()) {
            return $this->errorResponse('Necesitas ingresar otros valores para actualizar', 422);
        }*/
        $regperiodo->save();
        return $this->showOne($regperiodo);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Regperiodo  $regperiodo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Regperiodo $regperiodo)
    {
        $regperiodo->delete();
        return $this->showOne($regperiodo);
    }

    public function find(Request $request, Response $response)
    {
        $sortBy[] = $request->input('sort_by');
        $sortOrder[] = $request->input('sort_order');
        $pageSize[] = $request->input('pageSize');

        $idPeriodo = $request->request->get('state');

        $regperiodos = DB::table('regperiodos')
            ->select(
                'regperiodos.id', 'regperiodos.periodo_id', 'regperiodos.fecha', 'regperiodos.tipo_cambio',
                'regperiodos.ufv', 'regperiodos.activo'
            )
            ->where('regperiodos.deleted_at', '=', null) // Ocultar campos eliminados
            ->where('regperiodos.periodo_id', '=', $idPeriodo['entityId'])
            ->where(DB::raw('CONCAT(regperiodos.ufv," ",regperiodos.activo)'), 'like',  '%' . $request['search'] .'%')
            ->orderBy($sortBy[0], $sortOrder[0])
            ->paginate($pageSize[0]);

        // return response()->json(['data' => $regperiodos, 'code' => 201]);
        return $regperiodos;

    }
}
