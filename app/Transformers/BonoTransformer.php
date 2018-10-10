<?php

namespace App\Transformers;

use App\Bono;
use League\Fractal\TransformerAbstract;

class BonoTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Bono $bono)
    {
        return [
            'id' => (int)$bono->id,
            'idEmpleado' => (int)$bono->empleado_id,
            'idGestion' => (int)$bono->gestion_id,
            'idPeriodo' => (int)$bono->periodo_id,
            'creado' => (string)$bono->created_at,
            'modificado' => (string)$bono->updated_at,
            'eliminado' => isset($bono->deleted_at) ? (string) $bono->deleted_at : null,
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
