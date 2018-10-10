<?php

namespace App\Transformers;

use App\Periodo;
use League\Fractal\TransformerAbstract;

class PeriodoTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Periodo $periodo)
    {
        return [
            'id' => (int)$periodo->id,
            'fechaInicio' => (string)$periodo->inicio_mes,
            'fechaFin' => (string)$periodo->fin_mes,
            'procesado' => (int)$periodo->procesado,
            'cierre' => (int)$periodo->cierre,
            'cierreUFV' => (float)$periodo->cierre_ufv,
            'idGestion' => (int)$periodo->gestion_id,
            'creado' => (string)$periodo->created_at,
            'modificado' => (string)$periodo->updated_at,
            'eliminado' => isset($periodo->deleted_at) ? (string) $periodo->deleted_at : null,
        ];
    }

    public static function originalAttribute($index)
    {
        $attributes = [
            'id' => 'id',
            'fechaInicio' => 'inicio_mes',
            'fechaFin' => 'fin_mes',
            'procesado' => 'procesado',
            'cierre' => 'cierre',
            'cierreUFV' => 'cierre_ufv',
            'idGestion' => 'gestion_id',
            'creado' => 'created_at',
            'modificado' => 'updated_at',
            'eliminado' => 'deleted_at',
        ];
        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
