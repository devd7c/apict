<?php

namespace App\Transformers;

use App\Regperiodo;
use League\Fractal\TransformerAbstract;

class RegperiodoTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Regperiodo $regperiodo)
    {
        return [
            'id' => (int)$regperiodo->id,
            'nombre' => (string)$regperiodo->nombre,
            'fecha' => (string)$regperiodo->fecha,
            'tipoCambio' => (float)$regperiodo->tipo_cambio,
            'ufv' => (float)$regperiodo->ufv,
            'activo' => (string)$regperiodo->activo,
            'idPeriodo' => (int)$regperiodo->periodo_id,
            'creado' => (string)$regperiodo->created_at,
            'modificado' => (string)$regperiodo->updated_at,
            'eliminado' => isset($regperiodo->deleted_at) ? (string) $regperiodo->deleted_at : null,
        ];
    }

    public static function originalAttribute($index)
    {
        $attributes = [
            'id' => 'id',
            'nombre' => 'nombre',
            'fecha' => 'fecha',
            'tipoCambio' => 'tipo_cambio',
            'ufv' => 'ufv',
            'activo' => 'activo',
            'idPeriodo' => 'periodo_id',
            'creado' => 'created_at',
            'modificado' => 'updated_at',
            'eliminado' => 'deleted_at',
        ];
        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
