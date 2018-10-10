<?php

namespace App\Transformers;

use App\Proceso;
use League\Fractal\TransformerAbstract;

class ProcesoTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Proceso $proceso)
    {
        return [
            'id' => (int)$proceso->id,
            'idEmpresa' => (int)$proceso->empresa_id,
            'idGestion' => (int)$proceso->gestion_id,
            'idPeriodo' => (int)$proceso->periodo_id,
            'idRegPeriodo' => (int)$proceso->regperiodo_id,
            'idPatronal' => (int)$proceso->patronal_id,
            'idLaboral' => (int)$proceso->laboral_id,
            'creado' => (string)$proceso->created_at,
            'modificado' => (string)$proceso->updated_at,
            'eliminado' => isset($proceso->deleted_at) ? (string) $proceso->deleted_at : null,
        ];
    }

    public static function originalAttribute($index)
    {
        $attributes = [
            'id' => 'id',
            'idEmpresa' => 'empresa_id',
            'idGestion' => 'gestion_id',
            'idPeriodo' => 'periodo_id',
            'idRegPeriodo' => 'regperiodo_id',
            'idPatronal' => 'patronal_id',
            'idLaboral' => 'laboral_id',
            'creado' => 'created_at',
            'modificado' => 'updated_at',
            'eliminado' => 'deleted_at',
        ];
        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
