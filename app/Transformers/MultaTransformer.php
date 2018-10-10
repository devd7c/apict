<?php

namespace App\Transformers;

use App\Multa;
use League\Fractal\TransformerAbstract;

class MultaTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Multa $multa)
    {
        return [
            'id' => (int)$multa->id,
            'idEmpleado' => (int)$multa->empleado_id,
            'idGestion' => (int)$multa->gestion_id,
            'idPeriodo' => (int)$multa->periodo_id,
            'creado' => (string)$multa->created_at,
            'modificado' => (string)$multa->updated_at,
            'eliminado' => isset($multa->deleted_at) ? (string) $multa->deleted_at : null,
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
