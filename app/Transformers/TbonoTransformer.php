<?php

namespace App\Transformers;

use App\Tbono;
use League\Fractal\TransformerAbstract;

class TbonoTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Tbono $tbono)
    {
        return [
            'id' => (int)$tbono->id,
            'monto' => (float)$tbono->monto,
            'fecha' => (string)$tbono->fecha,
            'descripcion' => (string)$tbono->descripcion,
            'idBono' => (int)$tbono->bono_id,
            'creado' => (string)$tbono->created_at,
            'modificado' => (string)$tbono->updated_at,
            'eliminado' => isset($tbono->deleted_at) ? (string) $tbono->deleted_at : null,
        ];
    }

    public static function originalAttribute($index)
    {
        $attributes = [
            'id' => 'id',
            'monto' => 'monto',
            'fecha' => 'fecha',
            'descripcion' => 'descripcion',
            'idBono' => 'bono_id',
            'creado' => 'created_at',
            'modificado' => 'updated_at',
            'eliminado' => 'deleted_at',
        ];
        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
