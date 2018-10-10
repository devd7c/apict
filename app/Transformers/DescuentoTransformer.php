<?php

namespace App\Transformers;

use App\Descuento;
use League\Fractal\TransformerAbstract;

class DescuentoTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Descuento $descuento)
    {
        return [
            'id' => (int)$descuento->id,
            'idEmpleado' => (int)$descuento->empleado_id,
            'idGestion' => (int)$descuento->gestion_id,
            'idPeriodo' => (int)$descuento->periodo_id,
            'creado' => (string)$descuento->created_at,
            'modificado' => (string)$descuento->updated_at,
            'eliminado' => isset($descuento->deleted_at) ? (string) $descuento->deleted_at : null,
        ];
    }

    public static function originalAttribute($index)
    {
        $attributes = [
            'id' => 'id',
            'idEmpleado' => 'empleado_id',
            'idGestion' => 'gestion_id',
            'idPeriodo' => 'periodo_id',
            'creado' => 'created_at',
            'modificado' => 'updated_at',
            'eliminado' => 'deleted_at',
        ];
        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
