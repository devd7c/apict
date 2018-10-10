<?php

namespace App\Transformers;

use App\Sucursal;
use League\Fractal\TransformerAbstract;

class SucursalTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Sucursal $sucursal)
    {
        return [
            'id' => (int)$sucursal->id,
            'nombre' => (string)$sucursal->nombre,
            'direccion' => (string)$sucursal->direccion,
            'nit' => (string)$sucursal->nit,
            'ciudad' => (string)$sucursal->ciudad,
            'fono' => (string)$sucursal->fono,
            'nroPat' => (string)$sucursal->nro_pat,
            'idEmpresa' => (int)$sucursal->empresa_id,
            'creado' => (string)$sucursal->created_at,
            'modificado' => (string)$sucursal->updated_at,
            'eliminado' => isset($sucursal->deleted_at) ? (string) $sucursal->deleted_at : null,
        ];
    }

    public static function originalAttribute($index)
    {
        $attributes = [
            'id' => 'id',
            'nombre' => 'nombre',
            'direccion' => 'direccion',
            'nit' => 'nit',
            'ciudad' => 'ciudad',
            'fono' => 'fono',
            'nroPat' => 'nro_pat',
            'idEmpresa' => 'empresa_id',
            'creado' => 'created_at',
            'modificado' => 'updated_at',
            'eliminado' => 'deleted_at',
        ];
        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
