<?php

namespace App\Transformers;

use App\Domingo;
use League\Fractal\TransformerAbstract;

class DomingoTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Domingo $domingo)
    {
        return [
            'id' => (int)$domingo->id,
            'idEmpleado' => (int)$domingo->empleado_id,
            'idGestion' => (int)$domingo->gestion_id,
            'idPeriodo' => (int)$domingo->periodo_id,
            'creado' => (string)$domingo->created_at,
            'modificado' => (string)$domingo->updated_at,
            'eliminado' => isset($domingo->deleted_at) ? (string) $domingo->deleted_at : null,
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
