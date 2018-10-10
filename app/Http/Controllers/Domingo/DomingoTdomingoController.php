<?php

namespace App\Http\Controllers\Domingo;

use App\Domingo;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class DomingoTdomingoController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Domingo $domingo)
    {
        $tdomingos = $domingo->tdomingos;
        return $this->showAll($tdomingos);
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
     * @param  \App\Domingo  $domingo
     * @return \Illuminate\Http\Response
     */
    public function show(Domingo $domingo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Domingo  $domingo
     * @return \Illuminate\Http\Response
     */
    public function edit(Domingo $domingo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Domingo  $domingo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Domingo $domingo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Domingo  $domingo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Domingo $domingo)
    {
        //
    }
}
