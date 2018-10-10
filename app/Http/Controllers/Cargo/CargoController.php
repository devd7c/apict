<?php

namespace App\Http\Controllers\Cargo;

use App\Cargo;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class CargoController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cargos = Cargo::all();
        return $this->showAll($cargos);
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
        $data['nombre'] = $request->nombre;
        $data['descripcion'] = $request->descripcion;

        $cargo = Cargo::create($data);

        return $this->showOne($cargo, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cargo  $cargo
     * @return \Illuminate\Http\Response
     */
    public function show(Cargo $cargo)
    {
        return $this->showOne($cargo);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cargo  $cargo
     * @return \Illuminate\Http\Response
     */
    public function edit(Cargo $cargo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cargo  $cargo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cargo $cargo)
    {
        $cargo->fill($request->only([
            'nombre',
            'descripcion',
        ]));

        if ($cargo->isClean()) {
            return $this->errorResponse('Necesitas ingresar otros valores para actualizar', 422);
        }

        $cargo->save();
        return $this->showOne($cargo);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cargo  $cargo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cargo $cargo)
    {
        $cargo->delete();
        return $this->showOne($cargo);
    }
}
