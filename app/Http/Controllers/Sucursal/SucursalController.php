<?php

namespace App\Http\Controllers\Sucursal;

use App\Sucursal;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use phpDocumentor\Reflection\Types\String_;

class SucursalController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Response $response)
    {
        $sucursales = Sucursal::all();
        return $this->showAll($sucursales);
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
        $data['direccion'] = $request->direccion;
        $data['nit'] = $request->nit;
        $data['ciudad'] = $request->ciudad;
        $data['fono'] = $request->fono;
        $data['nro_pat'] = $request->nro_pat;
        $data['empresa_id'] = $request->empresa_id;

        $sucursal = Sucursal::create($data);

        return $this->showOne($sucursal, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Sucursal  $sucursal
     * @return \Illuminate\Http\Response
     */
    public function show(Sucursal $sucursal)
    {
        return $this->showOne($sucursal);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Sucursal  $sucursal
     * @return \Illuminate\Http\Response
     */
    public function edit(Sucursal $sucursal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Sucursal  $sucursal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sucursal $sucursal)
    {
        /*$getParams = new Sucursal();
        $getParams->nombre = $request->nombre == null ? $sucursal->nombre : $request->nombre;
        $getParams->direccion = $request->direccion == null ? $sucursal->direccion : $request->direccion;
        $getParams->nit = $request->nit == null ? $sucursal->nit : $request->nit;
        $getParams->ciudad = $request->ciudad == null ? $sucursal->ciudad : $request->ciudad;
        $getParams->fono = $request->fono == null ? $sucursal->fono : $request->fono;
        $getParams->nro_pat = $request->nroPat == null ? $sucursal->nro_pat : $request->nroPat;
        $getParams->empresa_id = $request->idEmpresa == null ? $sucursal->empresa_id : $request->idEmpresa;*/

        $sucursal->fill($request->only([
            'nombre',
            'direccion',
            'nit',
            'ciudad',
            'fono',
            'nro_pat',
            'empresa_id',
        ]));

        /*if ($sucursal->isClean()) {
            return $this->errorResponse('Necesitas ingresar otros valores para actualizar', 422);
        }*/
        $sucursal->save();
        return $this->showOne($sucursal);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sucursal  $sucursal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sucursal $sucursal)
    {
        $sucursal->delete();
        return $this->showOne($sucursal);
    }

    public function find(Request $request, Response $response)
    {
        $sortBy[] = $request->input('sort_by');
        $sortOrder[] = $request->input('sort_order');
        $pageSize[] = $request->input('pageSize');

        $idEmpresa = $request->request->get('state');

        $sucursals = DB::table('sucursals')
            ->select(
                'sucursals.id', 'sucursals.nombre', 'sucursals.direccion', 'sucursals.nit',
                'sucursals.ciudad', 'sucursals.fono', 'sucursals.nro_pat'
            )
            ->where('sucursals.deleted_at', '=', null) // Ocultar campos eliminados
            ->where('sucursals.empresa_id', '=', $idEmpresa['entityId'])
            ->where(DB::raw('CONCAT(sucursals.nombre," ",sucursals.ciudad," ",sucursals.nro_pat, " ",sucursals.nit)'), 'like',  '%' . $request['search'] .'%')
            ->orderBy($sortBy[0], $sortOrder[0])
            ->paginate($pageSize[0]);

        // return response()->json(['data' => $empresas, 'code' => 201]);
        return $sucursals;

    }
}
