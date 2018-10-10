<?php

namespace App\Http\Controllers\Psueldo;

use App\Psueldo;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use function MongoDB\BSON\toJSON;
use phpDocumentor\Reflection\Types\String_;

class PsueldoController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $psueldos = Psueldo::all();
        return $this->showAll($psueldos);
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
     * @param  \App\Psueldo  $psueldo
     * @return \Illuminate\Http\Response
     */
    public function show(Psueldo $psueldo)
    {
        return $this->showOne($psueldo);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Psueldo  $psueldo
     * @return \Illuminate\Http\Response
     */
    public function edit(Psueldo $psueldo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Psueldo  $psueldo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Psueldo $psueldo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Psueldo  $psueldo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Psueldo $psueldo)
    {
        $psueldo->delete();
        return $this->showOne($psueldo);
    }
}
