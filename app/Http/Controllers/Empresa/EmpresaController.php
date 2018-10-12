<?php

namespace App\Http\Controllers\Empresa;

use App\Empresa;
use App\Laboral;
use App\Patronal;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use function MongoDB\BSON\toJSON;
use phpDocumentor\Reflection\Types\String_;

class EmpresaController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Response $response)
    {
        $empresas = Empresa::all();
        return $this->showAll($empresas);
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
        return DB::transaction(function () use ($request) {
            $data = $request->all();
            $data['nombre'] = $request->nombre;
            $data['nit'] = $request->nit;
            $data['nombre_rep_legal'] = $request->nombre_rep_legal;
            $data['titulo_rep_legal'] = $request->titulo_rep_legal;
            $data['tipo_doc'] = $request->tipo_doc;
            $data['nro_doc'] = $request->nro_doc;
            $data['exp_doc'] = $request->exp_doc;

            $empresa = Empresa::create($data);

            Laboral::create([
                'smn' => 2060,
                'civ' => 10.00,
                'si' => 1.71,
                'comision_afp' => 0.50,
                'provivienda' => 0.00,
                'iva' => 13.00,
                'asa' => 0.50,
                'ans_13' => 1.00,
                'ans_25' => 5.00,
                'ans_35' => 10.00,
                'cba_1' => 5.00,
                'cba_2' => 11.00,
                'cba_3' => 18.00,
                'cba_4' => 26.00,
                'cba_5' => 34.00,
                'cba_6' => 42.00,
                'cba_7' => 50.00,
                'activo' => 1,
                'empresa_id' => $empresa->id,
            ]);

            Patronal::create([
                'sarp' => 1.71,
                'provivienda' => 2.00,
                'infocal' => 0.00,
                'cnss' => 10.00,
                'sip' => 3.00,
                'activo' => 1,
                'empresa_id' => $empresa->id,
            ]);

            return $this->showOne($empresa, 201);
        });
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Empresa  $empresa
     * @return \Illuminate\Http\Response
     */
    public function show(Empresa $empresa)
    {
        return $this->showOne($empresa);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Empresa  $empresa
     * @return \Illuminate\Http\Response
     */
    public function edit(Empresa $empresa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Empresa  $empresa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Empresa $empresa)
    {
        /*$getParams = new Empresa();
        $getParams->nombre = $request->nombre == null? $empresa->nombre : $request->nombre;
        $getParams->nit = $request->nit == null? $empresa->nit : $request->nit;
        $getParams->nombre_rep_legal = $request->nombreRepLegal == null? $empresa->nombre_rep_legal : $request->nombreRepLegal;
        $getParams->titulo_rep_legal = $request->tituloRepLegal == null? $empresa->titulo_rep_legal : $request->tituloRepLegal;
        $getParams->tipo_doc = $request->tipoDoc == null? $empresa->tipo_doc : $request->tipoDoc;
        $getParams->nro_doc = $request->nroDoc == null? $empresa->nro_doc : $request->nroDoc;
        $getParams->exp_doc = $request->expedidoDoc == null? $empresa->exp_doc : $request->expedidoDoc;*/

        return DB::transaction(function () use ($request, $empresa) {
            $empresa->fill($request->only([
                'nombre',
                'nit',
                'nombre_rep_legal',
                'titulo_rep_legal',
                'tipo_doc',
                'nro_doc',
                'exp_doc',
            ]));

            /*if ($empresa->isClean()) {
                return $this->errorResponse('Necesitas ingresar otros valores para actualizar', 422);
            }*/

            $empresa->save();
            return $this->showOne($empresa);
        });
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Empresa  $empresa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Empresa $empresa)
    {
        $empresa->delete();
        return $this->showOne($empresa);
    }

    public function find(Request $request, Response $response)
    {
        $sortBy[] = $request->input('sort_by');
        $sortOrder[] = $request->input('sort_order');
        $pageSize[] = $request->input('pageSize');

        $empresas = DB::table('empresas')
            ->select(
                'empresas.id', 'empresas.nombre', 'empresas.nit', 'empresas.nombre_rep_legal',
                'empresas.titulo_rep_legal', 'empresas.tipo_doc', 'empresas.nro_doc', 'empresas.exp_doc',
                DB::raw("(SELECT count(s.id) FROM sucursals s WHERE s.empresa_id = empresas.id AND s.deleted_at IS NULL) AS nro_sucursals")
            )
            ->where('empresas.deleted_at', '=', null) // Ocultar campos eliminados
            ->where(DB::raw("concat_ws(' ', empresas.nombre, empresas.nit, empresas.nombre_rep_legal, empresas.titulo_rep_legal)"), "LIKE",  "%" . $request["search"] ."%")
            ->orderBy($sortBy[0], $sortOrder[0])
            ->paginate($pageSize[0]);

        // return response()->json(['data' => $empresas, 'code' => 201]);
        return $empresas;
    }
}
