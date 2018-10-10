<?php

namespace App\Http\Controllers\Multa;

use App\Multa;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class MultaTmultaController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Multa $multa)
    {
        $tmultas = $multa->tmultas;
        return $this->showAll($tmultas);
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
     * @param  \App\Multa  $multa
     * @return \Illuminate\Http\Response
     */
    public function show(Multa $multa)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Multa  $multa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Multa $multa)
    {
        //
    }
}
