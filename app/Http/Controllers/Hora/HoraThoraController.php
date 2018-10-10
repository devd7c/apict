<?php

namespace App\Http\Controllers\Hora;

use App\Hora;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class HoraThoraController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Hora $hora)
    {
        $thoras = $hora->thoras;
        return $this->showAll($thoras);
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
     * @param  \App\Hora  $hora
     * @return \Illuminate\Http\Response
     */
    public function show(Hora $hora)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Hora  $hora
     * @return \Illuminate\Http\Response
     */
    public function edit(Hora $hora)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Hora  $hora
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Hora $hora)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Hora  $hora
     * @return \Illuminate\Http\Response
     */
    public function destroy(Hora $hora)
    {
        //
    }
}
