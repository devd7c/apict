<?php

namespace App\Http\Controllers\Empleado;

use App\Cargo;
use App\Contrato;
use App\Empleado;
use App\Empresa;
use App\Puesto;
use App\Sucursal;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use phpDocumentor\Reflection\Types\String_;

class EmpleadoController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Response $response)
    {
        //$empleado = Empleado::with('sucursal');
        $empleado = Empleado::all();

        //return $empleado;
        //return $this->showAll($empleado);
        $empleados = Empleado::with(['empresa', 'sucursal', 'contrato', 'puesto', 'cargo'])->paginate(100);

        return $empleados;
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
        /*$rules = [
            'tipo_doc' => 'required',
            'nro_doc' => 'required',
            'exp_doc' => 'required',
            'afiliacion' => 'required',
            'nua_cua' => 'required',
            'ap_paterno' => 'required',
            'ap_materno' => 'required',
            'nombre' => 'required',
            'nacionalidad' => 'required',
            'fecha_nacimiento' => 'required',
            'sexo' => 'required',
            'jubilado' => 'required',
            'fecha_ingreso' => 'required',
            'haber_basico' => 'required',
            'nro_matricula' => 'required',
            'categoria' => 'required',
            'domicilio' => 'required',
            'obrero' => 'required',
        ];

        $this->validate($request, $rules);*/

        $data = $request->all();
        $data['tipo_doc'] = $request->tipo_doc;
        $data['nro_doc'] = $request->nro_doc;
        $data['exp_doc'] = $request->exp_doc;
        $data['afiliacion'] = $request->afiliacion;
        $data['nua_cua'] = $request->nua_cua;
        $data['ap_paterno'] = $request->ap_paterno;
        $data['ap_materno'] = $request->ap_materno;
        $data['ap_casada'] = $request->ap_casada;
        $data['nombre'] = $request->nombre;
        $data['nacionalidad'] = $request->nacionalidad;
        $data['fecha_nacimiento'] = $request->fecha_nacimiento;
        $data['sexo'] = $request->sexo;
        $data['jubilado'] = $request->jubilado;
        $data['fecha_ingreso'] = $request->fecha_ingreso;
        $data['haber_basico'] = $request->haber_basico;
        $data['nro_matricula'] = $request->nro_matricula;
        $data['categoria'] = $request->categoria;
        $data['domicilio'] = $request->domicilio;
        $data['obrero'] = $request->obrero;
        $data['empresa_id'] = $request->empresa_id;
        $data['sucursal_id'] = $request->sucursal_id;
        $data['contrato_id'] = $request->contrato_id;
        $data['puesto_id'] = $request->puesto_id;
        $data['cargo_id'] = $request->cargo_id;


        $empleado = Empleado::create($data);

        return $this->showOne($empleado, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function show(Empleado $empleado)
    {
        // return $this->showOne($empleado);
        return Empleado::with(['empresa', 'sucursal', 'contrato', 'puesto', 'cargo'])->find($empleado->id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function edit(Empleado $empleado)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Empleado $empleado)
    {
        return DB::transaction(function () use ($request, $empleado) {

            /*$getParams = new Empleado();
            $getParams->tipo_doc = $request->tipoDoc == null ? $empleado->tipo_doc : $request->tipoDoc;
            $getParams->nro_doc = $request->nroDoc == null ? $empleado->nro_doc : $request->nroDoc;
            $getParams->exp_doc = $request->expedidoDoc == null ? $empleado->exp_doc : $request->expedidoDoc;
            $getParams->afiliacion = $request->afiliacion == null ? $empleado->afiliacion : $request->afiliacion;
            $getParams->nua_cua = $request->nuaCUA == null ? $empleado->nua_cua : $request->nuaCUA;
            $getParams->ap_paterno = $request->apPaterno == null ? $empleado->ap_paterno : $request->apPaterno;
            $getParams->ap_materno = $request->apMaterno == null ? $empleado->ap_materno : $request->apMaterno;
            $getParams->ap_casada = $request->apCasada == null ? $empleado->ap_casada : $request->apCasada;
            $getParams->nombre = $request->nombres == null ? $empleado->nombre : $request->nombres;
            $getParams->nacionalidad = $request->nacionalidad == null ? $empleado->nacionalidad : $request->nacionalidad;
            $getParams->fecha_nacimiento = $request->fechaNacimiento == null ? $empleado->fecha_nacimiento : $request->fechaNacimiento;
            $getParams->sexo = $request->genero == null ? $empleado->sexo : $request->genero;
            $getParams->jubilado = $request->jubilado == null ? $empleado->jubilado : $request->jubilado;
            $getParams->fecha_ingreso = $request->fechaIngreso == null ? $empleado->fecha_ingreso : $request->fechaIngreso;
            $getParams->fecha_retiro = $request->fechaRetiro == null ? $empleado->fecha_retiro : $request->fechaRetiro;
            $getParams->haber_basico = $request->haberBasico == null ? $empleado->haber_basico : $request->haberBasico;
            $getParams->nro_matricula = $request->nroMatricula == null ? $empleado->nro_matricula : $request->nroMatricula;
            $getParams->categoria = $request->categoria == null ? $empleado->categoria : $request->categoria;
            $getParams->domicilio = $request->domicilio == null ? $empleado->domicilio : $request->domicilio;
            $getParams->obrero = $request->obrero == null ? $empleado->obrero : $request->obrero;
            $getParams->empresa_id = $request->idEmpresa == null ? $empleado->empresa_id : $request->idEmpresa;
            $getParams->sucursal_id = $request->idSucursal == null ? $empleado->sucursal_id : $request->idSucursal;
            $getParams->contrato_id = $request->idContrato == null ? $empleado->contrato_id : $request->idContrato;
            $getParams->puesto_id = $request->idPuesto == null ? $empleado->puesto_id : $request->idPuesto;
            $getParams->cargo_id = $request->idCargo == null ? $empleado->cargo_id : $request->idCargo;*/

            $empleado->fill($request->only([
                'tipo_doc',
                'nro_doc',
                'exp_doc',
                'afiliacion',
                'nua_cua',
                'ap_paterno',
                'ap_materno',
                'ap_casada',
                'nombre',
                'nacionalidad',
                'fecha_nacimiento',
                'sexo',
                'jubilado',
                'fecha_ingreso',
                'fecha_retiro',
                'haber_basico',
                'nro_matricula',
                'categoria',
                'domicilio',
                'obrero',
                'empresa_id',
                'sucursal_id',
                'contrato_id',
                'puesto_id',
                'cargo_id',
            ]));

            if ($empleado->isClean()) {
                return $this->errorResponse('Necesitas ingresar otros valores para actualizar', 422);
            }

            $empleado->save();

            return $this->showOne($empleado);
            //return $empleado;
        });
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function destroy(Empleado $empleado)
    {
        $empleado->delete();
        return $this->showOne($empleado);
    }

    public function find(Request $request, Response $response)
    {
        /*$items = count($dependientes);
        for ($i = 0; $i <= $items; $i++) {
            $dependientes = $dependientes->filter(function ($value) {
                $value['nombreEmpresa'] = $this->getNameEmpresa($value->empresa_id);
                $value['nombreSucursal'] = $this->getNameSucursal($value->sucursal_id);
                $value['nombreContrato'] = $this->getNameContrato($value->contrato_id);
                $value['nombrePuesto'] = $this->getNamePuesto($value->puesto_id);
                $value['nombreCargo'] = $this->getNameCargo($value->cargo_id);
                return $value;
            });
        }*/
        //return $this->showAll($dependientes);
        $sortBy[] = $request->input('sort_by');
        $sortOrder[] = $request->input('sort_order');
        $pageSize[] = $request->input('pageSize');

        //$result[] = $request->all('sort_by');
        //$result[] = $request->input('sort_by');


        /*if ($sortOrder[0] == 'asc') {
            $dependientes = Empleado::with(['empresa', 'sucursal', 'contrato', 'puesto', 'cargo'])->orderBy($sortBy[0])->paginate(10);
        }
        if ($sortOrder[0] == 'desc') {
            $dependientes = Empleado::with(['empresa', 'sucursal', 'contrato', 'puesto', 'cargo'])->orderByDesc($sortBy[0])->paginate(10);
        }*/

        //$dependientes = Empleado::with(['empresa', 'sucursal', 'contrato', 'puesto', 'cargo'])->orderBy($sortBy[0], $sortOrder[0])->paginate($pageSize[0]);

        $dependientes = DB::table('empleados')
            ->select(
                'empleados.id', 'empleados.tipo_doc', 'empleados.nro_doc', 'empleados.exp_doc', 'empleados.afiliacion',
                DB::raw("CONCAT(empleados.ap_paterno,' ',empleados.ap_materno,' ',empleados.nombre) as nombre_completo"),
                'empleados.ap_paterno', 'empleados.ap_materno', 'empleados.ap_casada', 'empleados.nombre',
                'empleados.nua_cua', 'empleados.nacionalidad', 'empleados.fecha_nacimiento',
                'empleados.sexo', 'empleados.jubilado', 'empleados.fecha_ingreso', 'empleados.fecha_retiro',
                'empleados.haber_basico', 'empleados.nro_matricula', 'empleados.categoria', 'empleados.domicilio',
                'empleados.obrero', 'empleados.empresa_id', 'empleados.sucursal_id',
                'empleados.contrato_id', 'empleados.puesto_id', 'empleados.cargo_id',
                'empresas.nombre as nombre_empresa', 'empresas.nit', 'empresas.nombre_rep_legal',
                'empresas.titulo_rep_legal', 'empresas.tipo_doc', 'empresas.nro_doc', 'empresas.exp_doc',
                'contratos.nombre as nombre_contrato', 'contratos.descripcion as descripcion_contrato',
                'puestos.nombre as nombre_puesto', 'puestos.descripcion as descripcion_puesto',
                'cargos.nombre as nombre_cargo', 'cargos.descripcion as descripcion_cargo'
            )
            ->join('empresas','empresas.id','=','empleados.empresa_id')
            ->join('contratos', 'contratos.id', '=', 'empleados.contrato_id')
            ->join('puestos', 'puestos.id', '=', 'empleados.puesto_id')
            ->join('cargos', 'cargos.id', '=', 'empleados.cargo_id')
            ->groupBy('empleados.id')
            ->where('empleados.deleted_at', '=', null) // Ocultar campos eliminados
            ->where(DB::raw("CONCAT(empleados.ap_paterno,' ',empleados.ap_materno,' ',empleados.nombre,' ',contratos.nombre)"), "LIKE",  "%" . $request["search"] ."%")
            ->where(function ($query) use ($request) {
                if ($request['empresa'] != null) {
                    $query->where('empresas.id', '=', $request['empresa']);
                }
                if ($request['sexo'] != null) {
                    $query->where('empleados.sexo', '=', $request['sexo']);
                }
                if ($request['afiliacion'] != null) {
                    $query->where('empleados.afiliacion', '=', $request['afiliacion']);
                }
            })
            ->orderBy($sortBy[0], $sortOrder[0])
            ->paginate($pageSize[0]);

        return $dependientes;

        /*$result = $request->input();
        return response()->json(['data' => $result, 'code' => 201]);*/
    }
}
