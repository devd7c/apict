<?php

namespace App\Http\Controllers\Tdescuento;

use App\Tdescuento;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use phpDocumentor\Reflection\Types\String_;

class TdescuentoController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tdescuentos = Tdescuento::all();
        return $this->showAll($tdescuentos);
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


        $tdescuento = Tdescuento::create($data);

        return $this->showOne($tdescuento, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tdescuento  $tdescuento
     * @return \Illuminate\Http\Response
     */
    public function show(Tdescuento $tdescuento)
    {
        return $this->showOne($tdescuento);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tdescuento  $tdescuento
     * @return \Illuminate\Http\Response
     */
    public function edit(Tdescuento $tdescuento)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tdescuento  $tdescuento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tdescuento $tdescuento)
    {
        return DB::transaction(function () use ($request, $tdescuento) {
            $tdescuento->fill($request->only([
                'monto',
                'fecha',
                'descripcion',
                'descuento_id'
            ]));

            /*if ($tdescuento->isClean()) {
                return $this->errorResponse('Necesitas ingresar otros valores para actualizar', 422);
            }*/
            $tdescuento->save();
            return $this->showOne($tdescuento);
        });
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tdescuento  $tdescuento
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tdescuento $tdescuento)
    {
        $tdescuento->delete();
        return $this->showOne($tdescuento);
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

        $idDescuento = $request->request->get('state');

        $tdescuentos = DB::table('tdescuentos')
            ->select(
                'tdescuentos.id', 'tdescuentos.descuento_id', 'tdescuentos.monto', 'tdescuentos.fecha', 'tdescuentos.descripcion'
            )
            ->where('tdescuentos.deleted_at', '=', null) // Ocultar campos eliminados
            ->where('tdescuentos.descuento_id', '=', $idDescuento['entityId'])
            ->where('tdescuentos.descripcion', "LIKE",  "%" . $request["search"] ."%")
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

        return $tdescuentos;
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
