<?php

namespace App\Http\Controllers\Puesto;

use App\Puesto;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class PuestoController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $puestos = Puesto::all();
        return $this->showAll($puestos);
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

        $puesto = Puesto::create($data);

        return $this->showOne($puesto, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Puesto  $puesto
     * @return \Illuminate\Http\Response
     */
    public function show(Puesto $puesto)
    {
        return $this->showOne($puesto);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Puesto  $puesto
     * @return \Illuminate\Http\Response
     */
    public function edit(Puesto $puesto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Puesto  $puesto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Puesto $puesto)
    {
        $puesto->fill($request->only([
            'nombre',
            'descripcion',
        ]));

        if ($puesto->isClean()) {
            return $this->errorResponse('Necesitas ingresar otros valores para actualizar', 422);
        }

        $puesto->save();
        return $this->showOne($puesto);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Puesto  $puesto
     * @return \Illuminate\Http\Response
     */
    public function destroy(Puesto $puesto)
    {
        $puesto->delete();
        return $this->showOne($puesto);
    }
}
