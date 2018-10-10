<?php

namespace App\Http\Controllers\Contrato;

use App\Contrato;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class ContratoController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contratos = Contrato::all();
        return $this->showAll($contratos);
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

        $contrato = Contrato::create($data);

        return $this->showOne($contrato, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Contrato  $contrato
     * @return \Illuminate\Http\Response
     */
    public function show(Contrato $contrato)
    {
        return $this->showOne($contrato);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Contrato  $contrato
     * @return \Illuminate\Http\Response
     */
    public function edit(Contrato $contrato)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Contrato  $contrato
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contrato $contrato)
    {
        $contrato->fill($request->only([
            'nombre',
            'descripcion',
        ]));

        if ($contrato->isClean()) {
            return $this->errorResponse('Necesitas ingresar otros valores para actualizar', 422);
        }

        $contrato->save();
        return $this->showOne($contrato);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Contrato  $contrato
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contrato $contrato)
    {
        $contrato->delete();
        return $this->showOne($contrato);
    }
}
