<?php

namespace App\Http\Controllers\Patronal;

use App\Empresa;
use App\Patronal;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use phpDocumentor\Reflection\Types\String_;

class PatronalController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $patronals = Patronal::all();
        return $this->showAll($patronals);
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
            'sarp' => 'required',
            'provivienda' => 'required',
            'infocal' => 'required',
            'cnss' => 'required',
            'sip' => 'required',
            'activo' => 'required',
        ];

        $this->validate($request, $rules);*/

        return DB::transaction(function () use ($request) {
            $update = Patronal::all()
                ->where('activo', '=', 1)
                ->where('empresa_id', '=', $request->empresa_id)
                ->first();

            if ($update) {
                $update->activo = 2;
                $update->save();
            }

            $insert = Patronal::create($request->all());

            return $this->showOne($insert, 201);
        });
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Patronal  $patronal
     * @return \Illuminate\Http\Response
     */
    public function show(Patronal $patronal)
    {
        return $this->showOne($patronal);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Patronal  $patronal
     * @return \Illuminate\Http\Response
     */
    public function edit(Patronal $patronal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Patronal  $patronal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Patronal $patronal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Patronal  $patronal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Patronal $patronal)
    {
        $patronal->delete();
        return $this->showOne($patronal);
    }

    public function find(Request $request, Response $response)
    {
        $sortBy[] = $request->input('sort_by');
        $sortOrder[] = $request->input('sort_order');
        $pageSize[] = $request->input('pageSize');

        $idEmpresa = $request->request->get('state');

        $patronals = DB::table('patronals')
            ->select(
                'patronals.id', 'patronals.empresa_id', 'patronals.sarp', 'patronals.provivienda', 'patronals.infocal',
                'patronals.cnss', 'patronals.sip', 'patronals.activo'

            )
            ->where('patronals.deleted_at', '=', null) // Ocultar campos eliminados
            ->where('patronals.empresa_id', '=', $idEmpresa['entityId'])
            ->where(DB::raw('CONCAT(patronals.sarp," ",patronals.activo)'), 'like',  '%' . $request['search'] .'%')
            ->orderBy($sortBy[0], $sortOrder[0])
            ->paginate($pageSize[0]);

        // return response()->json(['data' => $patronals, 'code' => 201]);
        return $patronals;

    }
    public function getactive(Empresa $empresa) {
        $patronals = $empresa->patronals()
            ->where('empresa_id', '=', $empresa->id)
            ->where('activo', '=', 1)->first();
        //return response()->json(['data' => $patronals, 'code' => 201]);
        return $this->showOne($patronals);
    }
}
