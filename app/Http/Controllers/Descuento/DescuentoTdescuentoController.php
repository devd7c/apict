<?php

namespace App\Http\Controllers\Descuento;

use App\Descuento;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class DescuentoTdescuentoController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Descuento $descuento)
    {
        $tdescuentos = $descuento->tdescuentos;
        return $this->showAll($tdescuentos);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Descuento  $descuento
     * @return \Illuminate\Http\Response
     */
    public function show(Descuento $descuento)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Descuento  $descuento
     * @return \Illuminate\Http\Response
     */
    public function edit(Descuento $descuento)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Descuento  $descuento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Descuento $descuento)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Descuento  $descuento
     * @return \Illuminate\Http\Response
     */
    public function destroy(Descuento $descuento)
    {
        //
    }
}
