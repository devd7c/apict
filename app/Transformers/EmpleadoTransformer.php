<?php

namespace App\Transformers;

use App\Empleado;
use League\Fractal\TransformerAbstract;

class EmpleadoTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Empleado $empleado)
    {
        return [
            'id' => (int)$empleado->id,
            'tipoDoc' => (int)$empleado->tipo_doc, //1=CI, 2=RUN, 3=Pasaporte, 4=Carnet de extranjero o 5=Otro
            'nroDoc' => (string)$empleado->nro_doc,
            'expedidoDoc' => (string)$empleado->exp_doc, //Ejm: LP = La Paz
            'afiliacion' => (int)$empleado->afiliacion, //1=Previsión, 2=Futuro de Bolivia y 3=Otra
            'nuaCUA' => (string)$empleado->nua_cua,
            'apPaterno' => (string)$empleado->ap_paterno,
            'apMaterno' => (string)$empleado->ap_materno,
            'apCasada' => (string)$empleado->ap_casada,
            'nombres' => (string)$empleado->nombre,
            'nacionalidad' => (string)$empleado->nacionalidad,
            'fechaNacimiento' => (string)$empleado->fecha_nacimiento,
            'genero' => (int)$empleado->sexo, //1=F, 0=M
            'jubilado' => (int)$empleado->jubilado, //1=Si, 0=No
            'fechaIngreso' => (string)$empleado->fecha_ingreso,
            'fechaRetiro' => (string)$empleado->fecha_retiro,
            'haberBasico' => (float)$empleado->haber_basico,
            'nroMatricula' => (string)$empleado->nro_matricula,
            'categoria' => (string)$empleado->categoria,
            'domicilio' => (string)$empleado->domicilio,
            'obrero' => (int)$empleado->obrero, //1=Si, 0=No
            'idEmpresa' => (int)$empleado->empresa_id,
            'idSucursal' => (int)$empleado->sucursal_id,
            'idContrato' => (int)$empleado->contrato_id,
            'idPuesto' => (int)$empleado->puesto_id,
            'idCargo' => (int)$empleado->cargo_id,
            'creado' => (string)$empleado->created_at,
            'modificado' => (string)$empleado->updated_at,
            'eliminado' => isset($empleado->deleted_at) ? (string) $empleado->deleted_at : null,

            /*'links' => [
                [
                    'rel' => 'self',
                    'href' => route('empleados.show', $empleado->id),
                ],
            ]*/
        ];
    }

    public static function originalAttribute($index)
    {
        $attributes = [
            'id' => 'id',
            'tipoDoc' => 'tipo_doc',
            'nroDoc' => 'nro_doc',
            'expedidoDoc' => 'exp_doc',
            'afiliacion' => 'afiliacion',
            'nuaCUA' => 'nua_cua',
            'apPaterno' => 'ap_paterno',
            'apMaterno' => 'ap_materno',
            'apCasada' => 'ap_casada',
            'nombres' => 'nombre',
            'nacionalidad' => 'nacionalidad',
            'fechaNacimiento' => 'fecha_nacimiento',
            'genero' => 'sexo',
            'jubilado' => 'jubilado',
            'fechaIngreso' => 'fecha_ingreso',
            'fechaRetiro' => 'fecha_retiro',
            'haberBasico' => 'haber_basico',
            'nroMatricula' => 'nro_matricula',
            'categoria' => 'categoria',
            'domicilio' => 'domicilio',
            'obrero' => 'obrero',
            'idEmpresa' => 'empresa_id',
            'idSucursal' => 'sucursal_id',
            'idContrato' => 'contrato_id',
            'idPuesto' => 'puesto_id',
            'idCargo' => 'cargo_id',
            'creado' => 'created_at',
            'modificado' => 'updated_at',
            'eliminado' => 'deleted_at',
        ];
        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

    public static function transformedAttribute($index)
    {
        $attributes = [
            'id' => 'id',
            'tipo_doc' => 'tipoDoc',
            'nro_doc' => 'nroDoc',
            'exp_doc' => 'expedidoDoc',
            'afiliacion' => 'afiliacion',
            'nua_cua' => 'nuaCUA',
            'ap_paterno' => 'apPaterno',
            'ap_materno' => 'apMaterno',
            'ap_casada' => 'apCasada',
            'nombre' => 'nombres',
            'nacionalidad' => 'nacionalidad',
            'fecha_nacimiento' => 'fechaNacimiento',
            'sexo' => 'genero',
            'jubilado' => 'jubilado',
            'fecha_ingreso' => 'fechaIngreso',
            'fecha_retiro' => 'fechaRetiro',
            'haber_basico' => 'haberBasico',
            'nro_matricula' => 'nroMatricula',
            'categoria' => 'categoria',
            'domicilio' => 'domicilio',
            'obrero' => 'obrero',
            'empresa_id' => 'idEmpresa',
            'sucursal_id' => 'idSucursal',
            'contrato_id' => 'idContrato',
            'puesto_id' => 'idPuesto',
            'cargo_id' => 'idCargo',
            'created_at' => 'creationDate',
            'updated_at' => 'lastChange',
            'deleted_at' => 'deletedDate',
        ];
        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
