<?php

namespace App\Http\Controllers\Pafiliado;

use App\Pafiliado;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use function MongoDB\BSON\toJSON;
use phpDocumentor\Reflection\Types\String_;

class PafiliadoController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pafiliados = Pafiliado::all();
        return $this->showAll($pafiliados);
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
     * @param  \App\Pafiliado  $pafiliado
     * @return \Illuminate\Http\Response
     */
    public function show(Pafiliado $pafiliado)
    {
        return $this->showOne($pafiliado);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Pafiliado  $pafiliado
     * @return \Illuminate\Http\Response
     */
    public function edit(Pafiliado $pafiliado)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Pafiliado  $pafiliado
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pafiliado $pafiliado)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pafiliado  $pafiliado
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pafiliado $pafiliado)
    {
        $pafiliado->delete();
        return $this->showOne($pafiliado);
    }
}
