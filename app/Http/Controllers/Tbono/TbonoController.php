<?php

namespace App\Http\Controllers\Tbono;

use App\Tbono;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use phpDocumentor\Reflection\Types\String_;

class TbonoController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tbonos = Tbono::all();
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
        $data = $request->all();
        $data['monto'] = $request->monto;
        $data['fecha'] = $request->fecha;
        $data['descripcion'] = $request->descripcion;


        $tbono = Tbono::create($data);

        return $this->showOne($tbono, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tbono  $tbono
     * @return \Illuminate\Http\Response
     */
    public function show(Tbono $tbono)
    {
        return $this->showOne($tbono);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tbono  $tbono
     * @return \Illuminate\Http\Response
     */
    public function edit(Tbono $tbono)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tbono  $tbono
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tbono $tbono)
    {
        return DB::transaction(function () use ($request, $tbono) {
            $tbono->fill($request->only([
                'monto',
                'fecha',
                'descripcion',
                'bono_id',
            ]));

            /*if ($tbono->isClean()) {
                return $this->errorResponse('Necesitas ingresar otros valores para actualizar', 422);
            }*/
            $tbono->save();
            return $this->showOne($tbono);
        });
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tbono  $tbono
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tbono $tbono)
    {
        $tbono->delete();
        return $this->showOne($tbono);
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

        $idBono = $request->request->get('state');


        $tbonos = DB::table('tbonos')
            ->select(
                'tbonos.id', 'tbonos.bono_id', 'tbonos.monto', 'tbonos.fecha', 'tbonos.descripcion'
            )
            ->where('tbonos.deleted_at', '=', null) // Ocultar campos eliminados
            ->where('tbonos.bono_id', '=', $idBono['entityId'])
            ->where('tbonos.descripcion', "LIKE",  "%" . $request["search"] ."%")
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

        return $tbonos;
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
