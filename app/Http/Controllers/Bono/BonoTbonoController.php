<?php

namespace App\Http\Controllers\Bono;

use App\Bono;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class BonoTbonoController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Bono $bono)
    {
        $tbonos = $bono->tbonos;
        return $this->showAll($tbonos);
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
     * @param  \App\Bono  $bono
     * @return \Illuminate\Http\Response
     */
    public function show(Bono $bono)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Bono  $bono
     * @return \Illuminate\Http\Response
     */
    public function edit(Bono $bono)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Bono  $bono
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bono $bono)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Bono  $bono
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bono $bono)
    {
        //
    }
}
