<?php

namespace App\Http\Controllers\Tmulta;

use App\Tmulta;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use phpDocumentor\Reflection\Types\String_;

class TmultaController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tmultas = Tmulta::all();
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
        $data = $request->all();
        $data['monto'] = $request->monto;
        $data['fecha'] = $request->fecha;
        $data['descripcion'] = $request->descripcion;


        $tmulta = Tmulta::create($data);

        return $this->showOne($tmulta, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tmulta  $tmulta
     * @return \Illuminate\Http\Response
     */
    public function show(Tmulta $tmulta)
    {
        return $this->showOne($tmulta);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tmulta  $tmulta
     * @return \Illuminate\Http\Response
     */
    public function edit(Tmulta $tmulta)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tmulta  $tmulta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tmulta $tmulta)
    {
        return DB::transaction(function () use ($request, $tmulta) {
            $tmulta->fill($request->only([
                'monto',
                'fecha',
                'descripcion',
                'multa_id'
            ]));

            /*if ($tmulta->isClean()) {
                return $this->errorResponse('Necesitas ingresar otros valores para actualizar', 422);
            }*/
            $tmulta->save();
            return $this->showOne($tmulta);
        });
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tmulta  $tmulta
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tmulta $tmulta)
    {
        $tmulta->delete();
        return $this->showOne($tmulta);
    }

    public function find(Request $request, Response $response)
    {
        $sortBy[] = $request->input('sort_by');
        $sortOrder[] = $request->input('sort_order');
        $pageSize[] = $request->input('pageSize');

        $deleteArray = $request->input('state.deletedItems');
        $updateArray = $request->input('state.updatedItems');
        $insertArray = $request->input('state.addedItems');
        $itemsDelete = count($deleteArray);
        $itemsUpdate = count($updateArray);
        $itemsInsert = count($insertArray);

        $idMulta = $request->request->get('state');


        $tmultas = DB::table('tmultas')
            ->select(
                'tmultas.id', 'tmultas.multa_id', 'tmultas.monto', 'tmultas.fecha', 'tmultas.descripcion'
            )
            ->where('tmultas.deleted_at', '=', null) // Ocultar campos eliminados
            ->where('tmultas.multa_id', '=', $idMulta['entityId'])
            ->where('tmultas.descripcion', "LIKE",  "%" . $request["search"] ."%")
            ->orderBy($sortBy[0], $sortOrder[0])
            ->paginate($pageSize[0]);


        /*if ($itemsInsert != 0) {
            for ($i = 0; $i < $itemsInsert; $i++) {
                $insertItem = $request->input('state.addedItems.' . $i);
                $data = new Tmulta();
                $data->id = $this->getLastId() + $i;
                $data->multa_id= $insertItem['multa_id'];
                $data->monto = $insertItem['monto'];
                $data->fecha= $insertItem['fecha'];
                $data->descripcion= $insertItem['descripcion'];

                if ($this->searchIfExist($data->id) == false) {
                    $tmultas->push($data);
                }
            }
        }

        if ($itemsUpdate != 0) {
            for ($i = 0; $i <= $itemsUpdate; $i++) {
                $updateItem = $request->input('state.updatedItems.' . $i);

                if ($this->searchIfExist($updateItem['id']) == true) {
                    $tmultas = $tmultas->filter(function ($value) use ($updateItem) {

                        if ($value->id == $updateItem['id']) {
                            //$value->multa_id = $updateItem['multa_id'];
                            $value->monto = $updateItem['monto'];
                            $value->fecha = $updateItem['fecha'];
                            $value->descripcion = $updateItem['descripcion'];
                        }
                        return $value;
                    });
                }
            }
        }


        if ($itemsDelete != 0) {
            //$data = array();
            for ($i = 0; $i <= $itemsDelete; $i++) {
                $deleteItem = $request->input('state.deletedItems.' . $i);

                $key = $tmultas->search(function($item) use ($deleteItem) {
                    return $item->id == $deleteItem['id'];
                });

                if ($this->searchIfExist($deleteItem['id']) == true) {
                    $tmultas->pull($key);
                }
            }
        }*/

        //return response()->json(['data' => $tmultas, 'code' => 201]);

        return $tmultas;
    }

    /*private function searchIfExist($id) {
        $result = Tmulta::all()
            ->where('id', '=', $id)->first();
        if ($result != null) {
            return true;
        } else {
            return false;
        }
    }

    private function getLastId() {
        $result = Tmulta::all()->last();
        return $result->id + 1;
    }*/
}
