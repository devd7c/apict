<?php

namespace App\Transformers;

use App\Thora;
use League\Fractal\TransformerAbstract;

class ThoraTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Thora $thora)
    {
        return [
            'id' => (int)$thora->id,
            'cantidad' => (string)$thora->cantidad,
            'monto' => (float)$thora->monto,
            'fecha' => (string)$thora->fecha,
            'descripcion' => (string)$thora->descripcion,
            'idHora' => (int)$thora->hora_id,
            'creado' => (string)$thora->created_at,
            'modificado' => (string)$thora->updated_at,
            'eliminado' => isset($thora->deleted_at) ? (string) $thora->deleted_at : null,
        ];
    }

    public static function originalAttribute($index)
    {
        $attributes = [
            'id' => 'id',
            'cantidad' => 'cantidad',
            'monto' => 'monto',
            'fecha' => 'fecha',
            'descripcion' => 'descripcion',
            'idHora' => 'hora_id',
            'creado' => 'created_at',
            'modificado' => 'updated_at',
            'eliminado' => 'deleted_at',
        ];
        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
