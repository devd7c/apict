<?php

namespace App\Transformers;

use App\Hora;
use League\Fractal\TransformerAbstract;

class HoraTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Hora $hora)
    {
        return [
            'id' => (int)$hora->id,
            'idEmpleado' => (int)$hora->empleado_id,
            'idGestion' => (int)$hora->gestion_id,
            'idPeriodo' => (int)$hora->periodo_id,
            'creado' => (string)$hora->created_at,
            'modificado' => (string)$hora->updated_at,
            'eliminado' => isset($hora->deleted_at) ? (string) $hora->deleted_at : null,
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
