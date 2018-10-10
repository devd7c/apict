<?php

namespace App\Http\Controllers\Thora;

use App\Thora;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use phpDocumentor\Reflection\Types\String_;

class ThoraController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $thoras = Thora::all();
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
        $data = $request->all();
        $data['cantidad'] = $request->cantidad;
        $data['monto'] = $request->monto;
        $data['fecha'] = $request->fecha;
        $data['descripcion'] = $request->descripcion;


        $thora = Thora::create($data);

        return $this->showOne($thora, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Thora  $thora
     * @return \Illuminate\Http\Response
     */
    public function show(Thora $thora)
    {
        return $this->showOne($thora);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Thora  $thora
     * @return \Illuminate\Http\Response
     */
    public function edit(Thora $thora)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Thora  $thora
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Thora $thora)
    {
        return DB::transaction(function () use ($request, $thora) {
            $thora->fill($request->only([
                'cantidad',
                'monto',
                'fecha',
                'descripcion',
                'hora_id',
            ]));

            /*if ($thora->isClean()) {
                return $this->errorResponse('Necesitas ingresar otros valores para actualizar', 422);
            }*/
            $thora->save();
            return $this->showOne($thora);
        });
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Thora  $thora
     * @return \Illuminate\Http\Response
     */
    public function destroy(Thora $thora)
    {
        $thora->delete();
        return $this->showOne($thora);
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

        $idHora = $request->request->get('state');

        $thoras = DB::table('thoras')
            ->select(
                'thoras.id', 'thoras.hora_id', 'thoras.cantidad', 'thoras.monto', 'thoras.fecha', 'thoras.descripcion'
            )
            ->where('thoras.deleted_at', '=', null) // Ocultar campos eliminados
            ->where('thoras.hora_id', '=', $idHora['entityId'])
            ->where('thoras.descripcion', 'like',  '%' . $request['search'] .'%')
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

        return $thoras;
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
